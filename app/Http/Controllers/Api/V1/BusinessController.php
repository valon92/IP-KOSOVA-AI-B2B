<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterBusinessRequest;
use App\Http\Resources\BusinessDetailResource;
use App\Http\Resources\BusinessResource;
use App\Http\Resources\IndustryResource;
use App\Models\Business;
use App\Models\Client;
use App\Models\ClientBusinessLead;
use App\Models\Industry;
use App\Models\PageView;
use App\Services\Business\BusinessRegistrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    public function __construct(
        private readonly BusinessRegistrationService $registration
    ) {}

    public function detail(Request $request, Business $business): JsonResponse
    {
        $business->load(['industry', 'ipRanges']);

        $client = Auth::guard('client')->user();
        $lead = null;
        $analytics = null;

        if ($client instanceof Client) {
            $leadModel = ClientBusinessLead::query()
                ->where('client_id', $client->id)
                ->where('business_id', $business->id)
                ->first();

            if ($leadModel) {
                $lead = [
                    'id' => $leadModel->id,
                    'lead_score' => $leadModel->lead_score,
                    'status' => $leadModel->status,
                    'ip_address' => $leadModel->ip_address,
                    'visit_count' => $leadModel->visit_count,
                    'pages_visited' => $leadModel->pages_visited ?? [],
                    'total_time_spent' => $leadModel->total_time_spent,
                    'first_seen_at' => $leadModel->first_seen_at?->toIso8601String(),
                    'last_active_at' => $leadModel->last_active_at?->toIso8601String(),
                    'last_active_human' => $leadModel->last_active_at?->diffForHumans(),
                ];
            }

            $analytics = [
                'total_page_views' => PageView::where('client_id', $client->id)
                    ->where('business_id', $business->id)
                    ->count(),
                'unique_sessions' => PageView::where('client_id', $client->id)
                    ->where('business_id', $business->id)
                    ->distinct()
                    ->count('session_id'),
            ];
        }

        $request->attributes->set('detail_lead', $lead);
        $request->attributes->set('detail_analytics', $analytics);

        return response()->json([
            'data' => new BusinessDetailResource($business),
        ]);
    }

    public function register(RegisterBusinessRequest $request): JsonResponse
    {
        $business = $this->registration->register($request->validated());

        return response()->json([
            'message' => $business->is_verified
                ? 'Biznesi u regjistrua dhe është aktiv në regjistër.'
                : 'Biznesi u regjistrua. Në pritje të verifikimit nga ekipi IPKO.ai.',
            'data' => new BusinessResource($business),
        ], 201);
    }
    public function index(Request $request): JsonResponse
    {
        $businesses = Business::query()
            ->with('industry')
            ->when($request->boolean('active_only', true), fn ($q) => $q->active())
            ->when($request->filled('industry'), function ($q) use ($request) {
                $q->whereHas('industry', fn ($iq) => $iq->where('slug', $request->string('industry')));
            })
            ->when($request->filled('city'), fn ($q) => $q->where('city', $request->string('city')))
            ->orderByDesc('created_at')
            ->paginate($request->integer('per_page', 50));

        return BusinessResource::collection($businesses)->response();
    }

    public function show(Business $business): JsonResponse
    {
        $business->load(['industry', 'ipRanges']);

        return response()->json([
            'data' => new BusinessResource($business),
        ]);
    }

    public function industries(): JsonResponse
    {
        $industries = Industry::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->withCount(['businesses' => fn ($q) => $q->active()])
            ->get();

        return response()->json([
            'data' => IndustryResource::collection($industries),
        ]);
    }
}
