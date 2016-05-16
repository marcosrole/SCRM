<script type="text/javascript">  
function ocultarZona(){  
      if ( (document.forms[0].optionsRadios[1].checked == true ) )  
        {  
            document.getElementById('zona').style.display = 'block';  
        }  
      if ( (document.forms[0].optionsRadios[0].checked == true ) )  
        {  
            document.getElementById('zona').style.display = 'none';  
        }
    }    
</script>  
<script>      
function listarSucursal() {
      var content = $("#optionZona option:selected").text();   
      alert(content);
   });
</script>
    


<form name="Form1" action="#" >  
        <div class="radio">
          <label>
            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" onclick = "ocultarZona()">
            Mostrar todos
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2" onclick = "ocultarZona()">
            Mostrar por zona
          </label>
        </div>
</form> 
    <div id='zona' style='display:none;'>
        <select class="form-control" id="optionZona" onclick = "listarSucursal()">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
        </select>
    </div>
    