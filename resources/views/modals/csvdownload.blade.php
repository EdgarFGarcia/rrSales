<!-- Modal -->
<style type="text/css">
  @media (min-width: 768px) {
    .modal-xl {
      width: 100%;
      max-width:1200px;
    }
  }
</style>
<div class="modal fade" id="modalTableHolder" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">CSV<br/>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <center><img src="{{ asset('images/loading.gif') }}" id="modalLoading" class="hidden"/></center>
        <div id="modalDivTable" class="hidden">
          <table id="modalTable" class="display table table-bordered table-striped table-hover hidden modalTableTable" cellspacing="0" width="100%">
            
          </table>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalSort">Close</button>
      </div>
    </div>
  </div>
</div>