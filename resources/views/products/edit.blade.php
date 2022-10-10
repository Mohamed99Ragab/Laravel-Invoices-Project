<!-- edit -->
<div class="modal fade" id="modalEdit{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل المنتج</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{route('products.update','test')}}" method="post" autocomplete="off">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="id" id="id" value="{{$product->id}}">
                        <label for="recipient-name" class="col-form-label">اسم المنتج:</label>
                        <input class="form-control" name="name" id="name" type="text"value="{{$product->name}}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">حدد القسم</label>
                        <select name="section" class="form-control">
                            <option selected disabled> -- اختر القسم --</option>
                            @foreach($sections as $section)
                                <option value="{{$section->id}}" {{$product->section_id == $section->id ? 'selected':''}}>{{$section->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message-text" class="col-form-label">ملاحظات:</label>
                        <textarea class="form-control" id="description" name="description">{{$product->description}}</textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">حفظ</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
