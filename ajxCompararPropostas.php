<?php
	// Requisições de Arquivos Externos //
		require_once( "./classes/DAO/UtilsDAO.php" );
		require_once( "./classes/Utils/Util.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtil 			= new Util();
		$oUtilsDAO		= new UtilsDAO();
	// ==================== //
	
		$CTC_ID = $_REQUEST['CTC_ID'];
		$SELECIONADOS = $_REQUEST['SELECIONADOS'];
	
	// Verifico CPF na base //
		if ($SELECIONADOS != ''){
			$SELECIONADOS = substr ($SELECIONADOS,0,-1);
			$aSelecionados = explode (",",$SELECIONADOS);
                        
                        $oQry = mysql_query ("SELECT * FROM tb_cotacao WHERE CTC_ID = '$CTC_ID'");
                        $pQry = mysql_fetch_array ($oQry);
                        
			$TABLE =  '<table class="table table-striped">
                                <tr>
                                  <td class="titleColun">&nbsp;</td>';
                                  if ($pQry['CTC_AEREO'] == "1"){
                                      $TABLE .= '<td class="titTable"><strong>Valor Aéreo</strong></td>';
                                  }
                                  if ($pQry['CTC_HOTEL'] == "1"){
                                      $TABLE .= '<td class="titTable"><strong>Valor Hospedagem</strong></td>';
                                  }
                                  if ($pQry['CTC_ALUGUEL'] == "1"){
                                      $TABLE .= '<td class="titTable"><strong>Valor Aluguel</strong></td>';
                                  }
                                  
                                  $TABLE .= '<td class="titTable"><strong>Valor Total da Proposta</strong></td>
                                </tr>';
			foreach ($aSelecionados as $key => $value){
				$hQry = mysql_query ("SELECT * FROM tb_cotacao_proposta a INNER JOIN tb_usuario b
				ON a.USR_ID = b.USR_ID WHERE CTC_ID = '$CTC_ID'
				AND a.USR_ID = '$value'");
				$TotalAereo = NULL;
                                $TotalHotel = NULL;
                                $TotalAluguel = NULL;
                                $TotalAtividade = NULL;
				while ($jQry = mysql_fetch_array ($hQry)){
                                    
                                    if ($pQry['CTC_AEREO'] == "1"){
                                        $TotalAereo = $jQry["CPP_TOTAL_AEREO"];
                                        $AereoTotal = number_format ($jQry["CPP_TOTAL_AEREO"],2,',','.');
                                        $TotalAereo = str_replace (",",".",$TotalAereo);
                                    }
                                    if ($pQry['CTC_HOTEL'] == "1"){
                                        $TotalHotel = $jQry["CPP_TOTAL_HOTEL"];
                                        $HotelTotal = number_format ($jQry["CPP_TOTAL_HOTEL"],2,',','.');
                                        $TotalHotel = str_replace (",",".",$TotalHotel);
                                    }
                                    if ($pQry['CTC_ALUGUEL'] == "1"){
                                        $TotalAluguel = $jQry["CPP_TOTAL_ALUGUEL"];
                                        $AluguelTotal = number_format ($jQry["CPP_TOTAL_ALUGUEL"],2,',','.');
                                        $TotalAluguel = str_replace (",",".",$TotalAluguel);
                                    }
                                    if ($pQry['CTC_ATIVIDADE'] == "1"){
                                        $TotalAtividade = $jQry["CPP_TOTAL_ATIVIDADE"];
                                        $AtividadeTotal = number_format ($jQry["CPP_TOTAL_ATIVIDADE"],2,',','.');
                                        $TotalAtividade = str_replace (",",".",$TotalAtividade);
                                    }
					$TOTAL = $TotalAereo + $TotalAluguel + $TotalHotel + $TotalAtividade;
					$TOTAL = number_format ($TOTAL,2,',','.');
                                  
                                  $TABLE .= "<tr>
                                  <td class='titleColun'><strong>$jQry[USR_NOME]</strong></td>";
                                  if ($pQry['CTC_AEREO'] == "1"){
                                    $TABLE .= "<td>R$ $AereoTotal</td>";
                                  }
                                  if ($pQry['CTC_HOTEL'] == "1"){
                                    $TABLE .= "<td>R$ $HotelTotal</td>";
                                  }
                                  if ($pQry['CTC_ALUGUEL'] == "1"){
                                    $TABLE .= "<td>R$ $AluguelTotal</td>";
                                  }
                                  if ($pQry['CTC_ATIVIDADE'] == "1"){
                                    $TABLE .= "<td>R$ $AtividadeTotal</td>";
                                  }
                                  $TABLE .= "<td>R$ $TOTAL</td>
                                </tr>";
				
				}
			}
			$TABLE .= '</table>';
			echo (utf8_encode ($TABLE));
		}else{
			echo ('');
		}
	// ==================== //	
    
?>