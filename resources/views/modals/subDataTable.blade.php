<!-- Modal -->
<style type="text/css">
  @media (min-width: 768px) {
    .modal-xl {
      width: 100%;
      max-width:1200px;
    }
  }
</style>
<div class="modal fade" id="subDataTable" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Filter<br/>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <button type="button" class="btn btn-default" id="check">Check All</button>
        <button type="button" class="btn btn-default" id="uncheck">Uncheck All</button></h5>
        <button type="button" class="btn btn-primary" id="sortData">Filter</button>
        <center><img src="{{ asset('images/loading.gif') }}" id="loadingModal" class="hidden"/></center>
        <div class="container-fluid" id="toDivide" style="width: 100%; height: 450px; overflow-y: scroll; overflow-x: hidden">
          
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalSort">Close</button>
      </div>
    </div>
  </div>
</div>