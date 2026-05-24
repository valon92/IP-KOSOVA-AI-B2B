/**
 * Normalizon lead + business nga API në një objekt të unifikuar për UI.
 */
export function normalizeBusinessLead(lead) {
    const b = lead?.business ?? {};
    const businessId = b.id ?? lead.business_id ?? null;

    return {
        id: lead.id,
        business_id: businessId,
        lead_score: lead.lead_score,
        status: lead.status,
        pages_visited: lead.pages_visited ?? [],
        time_spent: lead.time_spent,
        visit_count: lead.visit_count,
        last_active_human: lead.last_active_human,
        name: b.name ?? lead.company_name ?? '—',
        slug: b.slug,
        location: b.location ?? lead.location ?? '—',
        industry: b.industry?.name ?? lead.industry ?? '—',
        industry_icon: b.industry?.icon ?? null,
        size_band: b.size_band,
        website: b.website,
        is_verified: b.is_verified ?? false,
        logo_url: b.logo_url ?? lead.logo_url,
    };
}

export function businessInitials(name) {
    if (!name || name === '—') return '?';
    return name
        .split(' ')
        .slice(0, 2)
        .map((w) => w[0])
        .join('')
        .toUpperCase();
}
