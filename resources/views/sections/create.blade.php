<!-- Basic modal -->
<div class="modal" id="modaldemo8">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">اضافة قسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <form action="{{route('sections.store')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">القسم</label>
                        <input type="text"name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">الوصف</label>
                        <textarea class="form-control"cols="6" name="description"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn ripple btn-success" type="button">تأكيد</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
                    </div>
                </form>


            </div>

        </div>
    </div>
</div>
<!-- End Basic modal -->
