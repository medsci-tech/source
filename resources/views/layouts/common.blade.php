<!-- 模态框1（Modal） -->
{{--提示 alert--}}
<div class="modal fade" id="ModalAlert" tabindex="-1" role="dialog" aria-labelledby="ModalAlertLabel" aria-hidden="true">
    <div class="modal-dialog" style="top:30%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">
                </button>
                <h4 class="modal-title" id="ModalAlertLabel">
                    提示信息
                </h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"
                        data-dismiss="modal">确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- 模态框2（Modal） -->
<div class="modal fade" id="comModal" tabindex="-1" role="dialog" aria-labelledby="comModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                </button>
                <h4 class="modal-title" id="comModalLabel">
                    提示消息
                </h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <a class="btn btn-default btn-url" href="">
                    确定
                </a>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- 模态框3（Modal） -->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="comModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                </button>
                <h4 class="modal-title" id="ModalLabel">
                    提示消息
                </h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal">
                    取消
                </button>
                <button class="btn btn-primary btn-confirm">
                    确定
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    var modelAlert = function(msg){
        $('#ModalAlert .modal-body').html(msg);
        $('#ModalAlert').modal('show');
    }

    var modelCom = function(msg,url){
        $('#comModal .modal-body').html(msg);
        $('#comModal .btn-url').attr('href',url);
        $('#comModal').modal('show');

    }
    var modelConfirm = function(msg,fuc){
        $('#Modal .modal-body').html(msg);
        $('#Modal').modal('show');
        $('#Modal .btn-confirm').on('click',fuc);

    }
</script>