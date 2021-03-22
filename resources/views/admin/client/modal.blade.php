<div id="responsive-modal" class="modal fade modal-css"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="overflow:hidden;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Статус телефона</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Статус телефона:</label>
                        <div style="width: 100%" class="">
                            <select style="width: 100%" id="is_confirm_phone" name="is_confirm_phone"  class=" select2">
                                <option value="0" @if($row->is_confirm_phone == 0) selected="selected"  @endif>Еще не проверено</option>
                                <option value="1" @if($row->is_confirm_phone == 1) selected="selected" @endif>Подтвержден</option>
                                <option value="2" @if($row->is_confirm_phone == 2) selected="selected" @endif>Не подтвержден</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light" onclick="savePhoneStatus('{{$row->user_id}}')">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>