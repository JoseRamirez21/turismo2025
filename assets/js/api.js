// Helper simple para consumir la API (otro hosting)
export async function getJSON(url, options = {}) {
  const res = await fetch(url, { headers: { 'Accept': 'application/json' }, ...options });
  if (!res.ok) throw new Error(`HTTP ${res.status}`);
  return await res.json();
}
