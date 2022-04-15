<?php
    //Variables to connect into database
	$server = "localhost";
	$username = "root";
	$pass = "hiago@1504";
	$db = "hiagocs";

	//If connection failed returns error, else returns nothing
	$conn = new mysqli($server, $username, $pass, $db);
	if ($conn->connect_error) {
 	 die("Connection failed: " . $conn->connect_error);
	}

	function showInstitutes(){
		$query = 'SELECT * FROM tb_institute, tb_class WHERE id_institute = (SELECT id FROM tb_institute);';
		$result = $GLOBALS['conn']->query($query);
		while ($class_institute = mysqli_fetch_assoc($result)) {
			$class_institute['dt_inicio'] = DateTime::createFromFormat("Y-m-d", $class_institute['dt_inicio']);
			if($class_institute['dt_termino']){
				$dt_formatada = DateTime::createFromFormat("Y-m-d", $class_institute['dt_termino']);
				$class_institute['dt_termino'] = $dt_formatada->format("d/m/Y");
			}
			else{
				$class_institute['dt_termino'] = "--/--/--";
			}
			echo "<div>
						<img id='imgInstitute' src='".$class_institute['img_link']."' height='118' width='118'/>
						<p id='img_link'>Fonte: <a href='".$class_institute['institute_link']."'>".$class_institute['institute_link']."</a></p>
						<p id='endereço'>".$class_institute['city'].", ".$class_institute['uf'].", ".$class_institute['country']."</p>
					  </div>
					  <div>
					  	<h4>".$class_institute['nm_institute']."</h4>
					  	<p>".$class_institute['nm_class']." | ".$class_institute['dt_inicio']->format("d/m/Y")." - ".$class_institute['dt_termino']."</p>
					  	<p>Tel.: ".formataTelefone($class_institute['tel']).", E-mail: ".$class_institute['email']."</p>
					  </div>
					  <hr>";
		}
	}
	function formataTelefone($numero){
        if(strlen($numero) == 10){
            $novo = substr_replace($numero, '(', 0, 0);
            $novo = substr_replace($novo, '9', 3, 0);
            $novo = substr_replace($novo, ')', 3, 0);
        }else{
            $novo = substr_replace($numero, '(', 0, 0);
            $novo = substr_replace($novo, ')', 3, 0);
        }
        return $novo;
    }
?>