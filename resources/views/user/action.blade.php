<a href="{{ route('user.edit', [$user->id]) }}" class="btn icon btn-primary"><span
    class="fa-fw select-all fas"></span></a>

<button class="btn icon btn-danger" data-bs-toggle="modal"
data-bs-target="#default-delete{{$user->id}}"> <i class="bi bi-trash3-fill"></i></button>


<div class="modal fade text-left" id="default-delete{{$user->id}}" tabindex="-1" user="dialog" aria-hidden="true">

    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header flex-column">
                                
                <h4 class="modal-title w-100">Are you sure?</h4>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete these records? This process cannot be undone.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <form class="form" method="DELETE" action="{{route('user.destroy', $user->id)}}" enctype="multipart/form-data">
                    <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>


</div>
