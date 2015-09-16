<?php
$this->widget(
    'booster.widgets.TbJumbotron',
    array(
        'heading' => 'Sistema de Control de Ruidos Molestos',
        'encodeHeading'=>'true',
        'htmlOptions' => array(),
        'headingOptions'=> array(),
    )
);
?>

<?php 
    $form = $this->beginWidget(
        'booster.widgets.TbActiveForm',
        array(
            'id' => 'verticalForm',
            'htmlOptions' => array('class' => 'well'), // for inset effect
        )
    );
    echo $form->textFieldGroup($usuario, 'name');
    echo $form->passwordFieldGroup($usuario, 'pass');    
    $this->widget(
        'booster.widgets.TbButton',
        array('buttonType' => 'submit', 'label' => 'Login')
    );
    $this->endWidget();


?>