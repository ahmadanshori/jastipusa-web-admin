<div style="display: flex; gap: 5px;">
      @if (App\Models\User::checkRole('master_admin'))
<a href="{{ route('purchase.edit', [$purchase->id]) }}" class="btn icon btn-primary"><span
    class="fa-fw select-all fas"></span></a>
    @endif

<a href="{{ route('purchase.show', [$purchase->id]) }}" class="btn icon btn-warning"> <i class="bi bi-eye-fill"></i></a>
{{-- <a href="{{ route('purchase.pdf', [$purchase->id]) }}" class="btn icon btn-info"> <i class="fas fa-file-pdf me-2"></i></a> --}}


      @if (App\Models\User::checkRole('master_admin'))

<button class="btn icon btn-danger" data-bs-toggle="modal" 
        data-bs-target="#deleteModal{{$purchase->id}}">
    <i class="bi bi-trash3-fill"></i>
</button>
</div>

<div class="modal fade" id="deleteModal{{$purchase->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus purchase #{{$purchase->id}}? Data tidak dapat dikembalikan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                
                <!-- Form Delete yang Benar -->
                <form id="deleteForm{{$purchase->id}}" method="POST" action="{{ route('purchase.destroy', $purchase->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif