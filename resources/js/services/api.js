export async function getInitiatives() {
    const res = await fetch("/api/initiatives");
    const json = await res.json();
    return Array.isArray(json?.data) ? json.data : json; // supports resource collection
}

export async function createInitiative(payload) {
    const res = await fetch("/api/initiatives", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload),
    });
    if (!res.ok) throw await res.json();
    return res.json();
}

export async function updateInitiative(id, payload) {
    const res = await fetch(`/api/initiatives/${id}`, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload),
    });
    if (!res.ok) throw await res.json();
    return res.json();
}

export async function deleteInitiative(id) {
    const res = await fetch(`/api/initiatives/${id}`, { method: "DELETE" });
    if (!res.ok && res.status !== 204) throw await res.json();
}
