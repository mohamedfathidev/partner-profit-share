<form action="{{ route('partners.destroy', $row->id) }}" method="post">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-sm btn-danger">حذف</button>
</form>
