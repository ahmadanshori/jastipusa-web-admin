<div style="display: flex; gap: 5px;">
<a href="{{ route('payment-method.edit', [$paymentMethod->id]) }}" class="btn icon btn-primary"><span
        class="fa-fw select-all fas"></span></a>

<button class="btn icon btn-danger" data-bs-toggle="modal" 
        data-bs-target="#deleteModal{{$paymentMethod->id}}">
    <i class="bi bi-trash3-fill"></i>
</button>
</div>

<div class="modal fade" id="deleteModal{{$paymentMethod->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus payment method #{{$paymentMethod->id}}? Data tidak dapat dikembalikan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                
                <!-- Form Delete yang Benar -->
                <form id="deleteForm{{$paymentMethod->id}}" method="POST" action="{{ route('payment-method.destroy', $paymentMethod->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>