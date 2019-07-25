<!-- Modal -->
<style type="text/css">
  @media (min-width: 768px) {
    .modal-xl {
      width: 100%;
      max-width:1200px;
    }
  }
</style>
<div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
          <li class="nav-item active">
            <a class="nav-link active" data-toggle="tab" href="#graph">Graph</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#drillDownContent">Table</a>
          </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div class="col-md-12">
            <div class="tab-pane container active" id="graph" style="width: 100%; height: 400px;"></div>
          </div>
          <div class="col-md-12">
            <div class="tab-pane container fade" id="drillDownContent" style="width: 100%; height: 400px;"></div>
          </div>
        <div class="tab-pane container active" id="value"></div>
        <!-- </div> -->
        <!-- <div id="drillDownContent" style="width: 100%;"></div> -->
        <!-- <div id="drillDownLabel" style="width: 100%;"></div> -->
        <!-- <div id="drillDownContent" style="width: 100%; background-color: #cccs"></div> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>