<!DOCTYPE html>
<html>
<head>  
  <style>
  .modal-header, h4, .close {
      background-color: #19A3FF;
      color:white !important;
      text-align: center;
      font-size: 30px;
  }
  .modal-footer {
      background-color: #19A3FF;
  }
  </style>
</head>
<body>

<div class="container">
  <h2>Modal Login Example</h2>
  
  <button type="button" class="btn btn-success" id="myBtn">Login</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
          
        <div class="modal-header" style="padding:35px 50px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-pencil"></span> Modificar</h4>
        </div>
          
        <div class="modal-body" style="padding:40px 50px;">
          <form role="form">
            <div class="form-group">
              <label for=""><span class="glyphicon glyphicon-lock"></span> Rason Social</label>
              <input type="text" class="form-control" id="cuit_emp" placeholder="Ingrese Razon Social">
            </div>
            <div class="form-group">
              <label for=""><span class="glyphicon glyphicon-bullhorn"></span> Dispositivo</label>
              <input type="text" class="form-control" id="id_dis" placeholder="Dispositivo...">
            </div>
            <div class="form-group">
              <label for=""><span class="glyphicon glyphicon-exclamation-sign"></span> Observaciones</label>
              <input type="text" class="form-control" id="observacion" placeholder="Observaciones (Opcional)">
            </div>
            
              <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Modificar</button>
          </form>
        </div>
          
        <div class="modal-footer">
         <!-- <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
          <p>Not a member? <a href="#">Sign Up</a></p>
          <p>Forgot <a href="#">Password?</a></p>
        </div>-->
      </div>
      
    </div>
  </div> 
</div>
 
<script>
$(document).ready(function(){
    $("#myBtn").click(function(){
        $("#myModal").modal();
    });
});
</script>

</body>
</html>
