<script>
function goBack() {
    window.history.back();
}
</script>
<style>
    .modalDialog {
	position: fixed;
	font-family: Arial, Helvetica, sans-serif;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	background: rgba(0,0,0,0.8);
	z-index: 99999;
	opacity:0;
	-webkit-transition: opacity 400ms ease-in;
	-moz-transition: opacity 400ms ease-in;
	transition: opacity 400ms ease-in;
	pointer-events: none;        
        }
        .modalDialog:target {
                opacity:1;
                pointer-events: auto;
        }

        .modalDialog > div {
                width: 400px;
                position: relative;
                margin: 10% auto;
                padding: 5px 20px 13px 20px;
                border-radius: 10px;
                background: #fff;
                background: -moz-linear-gradient(#fff, #999);
                background: -webkit-linear-gradient(#fff, #999);
                background: -o-linear-gradient(#fff, #999);
        }
</style>


<div id="openModal" class="modalDialog">
	<div>
		<a onclick="goBack()" title="Close" class="close">X</a>
		<div align="CENTER" class="about">
                <h3><strong><i> Sistema de Control de Ruidos Molestos</i></strong></h3>
                <address>
                    <p> <strong>Marcos Role</strong> </p>
                    <p> <a href="mailto:marcosrole@gmail.com?Subject=SCRM%20Sistema" target="_top">marcosrole@gmail.com</a> </p>
                </address> 
                V.01 - 2015 -
            </div>
	</div>
</div>

