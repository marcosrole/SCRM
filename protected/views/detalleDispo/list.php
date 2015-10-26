<style>
    #page
    {
	margin-top: 5px;
	margin-bottom: 5px;
	background: white;	
    }
    
    .grafico{
        float: right;
        width: 55%;
        margin-bottom: 40px;
        
    }
    .tabla{
        float: left;
        width: 35%;
        margin-left: 50px;
        
    }
    
    h1.text_title {
    text-align: center;
        margin-bottom: 30px;
}
    
    
</style>

<?php 
//$self="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI']; //obtengo la URL donde estoy
//header("refresh:10; url=$self"); //Refrescamos cada 10 segundos
//?>


<?php $this->menu=array(
	array('label'=>'Listar Empresa', 'url'=>array('list')),
	array('label'=>'Crear Empresa', 'url'=>array('create')),
);
?>



    <h1 class="text_title">
        Detalles del Dispositivo: <?php echo $id_dis ?>
    </h1>

<div class="tabla">
    <?php $this->renderPartial('_table',array(
            'dataProvider'=>$dataProvider,            
    )); ?>


</div>
<div class="grafico">
    <?php $this->renderPartial('_graph1',array(
            'id_dis'=>$id_dis,
            'datos_grafico'=>$datos_grafico,
    )); ?>
</div>

<div class="grafico">
    <?php $this->renderPartial('_graph2',array(
            'id_dis'=>$id_dis,
            'datos_grafico'=>$datos_grafico,
    )); ?>
</div>





