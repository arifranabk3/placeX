import { ApiResponse } from '@/types';

const API_BASE_URL = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8000/api/v1';

export async function fetchApi<T>(endpoint: string, options: RequestInit = {}): Promise<ApiResponse<T>> {
  const token = typeof window !== 'undefined' ? localStorage.getItem('placex_token') : null;

  const headers: HeadersInit = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    ...(token ? { Authorization: `Bearer ${token}` } : {}),
    ...options.headers,
  };

  const response = await fetch(`${API_BASE_URL}${endpoint}`, {
    ...options,
    headers,
  });

  const data = await response.json();

  if (!response.ok) {
    throw new Error(data.message || 'API request failed');
  }

  return data;
}

export const placexApi = {
  health: () => fetchApi<{ status: string }>('/health'),
  getCategories: () => fetchApi<import('@/types').Category[]>('/categories'),
  getListings: (params: Record<string, string | number> = {}) => {
    const query = new URLSearchParams(params as Record<string, string>).toString();
    return fetchApi<import('@/types').Listing[]>(`/listings${query ? `?${query}` : ''}`);
  },
  getListing: (slug: string) => fetchApi<import('@/types').Listing>(`/listings/${slug}`),
};

