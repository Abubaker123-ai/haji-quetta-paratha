@extends('admin.layout', ['title' => 'Menu'])

@section('content')
    <div class="page-head">
        <div>
            <h2>Menu Items</h2>
            <div class="sub">Add, edit, or change availability — changes appear in the app within 30 seconds.</div>
        </div>
        <button class="btn" onclick="openAddModal()">+ Add Item</button>
    </div>

    <div class="card" style="padding:0;overflow:hidden;">
        <table>
            <thead>
                <tr>
                    <th></th><th>Name</th><th>Category</th><th>Price</th><th>Status</th><th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td>
                            @if ($item->image_url)
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="item-img">
                            @else
                                <div class="item-img">{{ $item->emoji ?: '🍽️' }}</div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight:600;">{{ $item->name }}</div>
                            <div style="font-size:12px;color:#6b7280;margin-top:2px;">{{ $item->item_id }} · {{ Str::limit($item->description, 50) }}</div>
                        </td>
                        <td>{{ $item->category }}</td>
                        <td><strong>Rs. {{ (int) $item->price }}</strong></td>
                        <td>
                            @if ($item->available)
                                <span class="badge badge-available">✓ In Stock</span>
                            @else
                                <span class="badge badge-out">✕ Out of Stock</span>
                            @endif
                        </td>
                        <td style="text-align:right;white-space:nowrap;">
                            <form action="{{ route('admin.menu.toggle', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @if ($item->available)
                                    <button type="submit" class="btn btn-sm btn-danger" title="Mark as out of stock">📤 Stock Out</button>
                                @else
                                    <button type="submit" class="btn btn-sm" style="background:#10b981;" title="Mark as in stock">📥 Stock In</button>
                                @endif
                            </form>
                            <button class="btn btn-sm btn-secondary" onclick='openEditModal(@json($item))'>✎ Edit</button>
                            <form action="{{ route('admin.menu.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete {{ $item->name }} permanently?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">🗑</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;padding:40px;color:#6b7280;">No menu items yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Add modal --}}
    <div class="modal-bg" id="addModal">
        <div class="modal">
            <h3>Add New Item</h3>
            <form action="{{ route('admin.menu.store') }}" method="POST">
                @csrf
                <div class="form-row"><label>Item ID (unique short code, e.g. p9)</label><input name="item_id" required></div>
                <div class="form-row"><label>Name</label><input name="name" required></div>
                <div class="form-row"><label>Price (Rs.)</label><input type="number" step="0.01" name="price" required></div>
                <div class="form-row"><label>Category</label>
                    <select name="category" required>
                        <option>Parathas</option><option>Drinks</option><option>Extras</option><option>Other</option>
                    </select>
                </div>
                <div class="form-row"><label>Description</label><textarea name="description" rows="2"></textarea></div>
                <div class="form-row"><label>Emoji (fallback icon)</label><input name="emoji" placeholder="🍽️"></div>
                <div class="form-row"><label>Image URL (optional)</label><input name="image_url" placeholder="https://..."></div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('addModal')">Cancel</button>
                    <button type="submit" class="btn">Add Item</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit modal --}}
    <div class="modal-bg" id="editModal">
        <div class="modal">
            <h3>Edit Item</h3>
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <div class="form-row"><label>Name</label><input name="name" id="editName" required></div>
                <div class="form-row"><label>Price (Rs.)</label><input type="number" step="0.01" name="price" id="editPrice" required></div>
                <div class="form-row"><label>Category</label>
                    <select name="category" id="editCategory" required>
                        <option>Parathas</option><option>Drinks</option><option>Extras</option><option>Other</option>
                    </select>
                </div>
                <div class="form-row"><label>Description</label><textarea name="description" id="editDesc" rows="2"></textarea></div>
                <div class="form-row"><label>Emoji</label><input name="emoji" id="editEmoji"></div>
                <div class="form-row"><label>Image URL</label><input name="image_url" id="editImage"></div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('editModal')">Cancel</button>
                    <button type="submit" class="btn">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function openAddModal() { document.getElementById('addModal').classList.add('show'); }
    function closeModal(id) { document.getElementById(id).classList.remove('show'); }
    function openEditModal(item) {
        document.getElementById('editForm').action = '/admin/menu/' + item.id;
        document.getElementById('editName').value = item.name;
        document.getElementById('editPrice').value = item.price;
        document.getElementById('editCategory').value = item.category;
        document.getElementById('editDesc').value = item.description || '';
        document.getElementById('editEmoji').value = item.emoji || '';
        document.getElementById('editImage').value = item.image_url || '';
        document.getElementById('editModal').classList.add('show');
    }
    document.querySelectorAll('.modal-bg').forEach(m => m.addEventListener('click', e => { if (e.target === m) m.classList.remove('show'); }));
</script>
@endpush
