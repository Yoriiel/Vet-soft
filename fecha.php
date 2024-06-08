<?php
                                        // Establecer la zona horaria a la de Ciudad de Panama
                                        date_default_timezone_set('America/Panama');
                            
                                        // Arreglo de traducción de días en inglés a español
                                        $dias = array(
                                            "Monday" => "Lunes",
                                            "Tuesday" => "Martes",
                                            "Wednesday" => "Miércoles",
                                            "Thursday" => "Jueves",
                                            "Friday" => "Viernes",
                                            "Saturday" => "Sábado",
                                            "Sunday" => "Domingo"
                                        );

                                        // Arreglo de traducción de meses en inglés a español
                                        $meses = array(
                                            "January" => "Enero",
                                            "February" => "Febrero",
                                            "March" => "Marzo",
                                            "April" => "Abril",
                                            "May" => "Mayo",
                                            "June" => "Junio",
                                            "July" => "Julio",
                                            "August" => "Agosto",
                                            "September" => "Septiembre",
                                            "October" => "Octubre",
                                            "November" => "Noviembre",
                                            "December" => "Diciembre"
                                        );

                                        // Obtiene el día, mes y año actuales en inglés
                                        $diaEnIngles = date("l");
                                        $mesEnIngles = date("F");
                                        $dia = date("j");
                                        $anio = date("Y");

                                        // Traduce el día y el mes al español
                                        $diaEnEspanol = $dias[$diaEnIngles];
                                        $mesEnEspanol = $meses[$mesEnIngles];
                                         
                                        $fecha = $dia." ".$mesEnEspanol." ".$anio;
                                        

?>