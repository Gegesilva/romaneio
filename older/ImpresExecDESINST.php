
<?php
  $cod = $_POST['cod'];
  include_once("conexaoSQL.php");
?>


<!doctype html>
<html lang="pt-BR">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="css/main.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/jsbarcode/3.6.0/JsBarcode.all.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <title>DATABIT</title>
  </head>
<body>
  <a href="http://localhost:8090/romaneio/impresDESINST.php">
    <img src="media/logo.png" width="100px" height="24px" alt="Logo">
  </a>
  <div class="nome-doc">
    <div class='titulo-cab'><b>TERMO DE DESINSTALAÇÃO DE EQUIPAMENTO</b></div>
 </div>

<div class="cabeçalho">

    <?php
        $sql = "
                SELECT 
                  --EMPRESA
                  TB02030_CODIGO Pedido,
                  TB01007_NOME NomeEmp,
                  TB01007_CNPJ CNPJEmp,
                  TB01007_INSCEST InscricaoEstEmp,
                  EMP.TB00012_END RuaEmp,
                  CAST(EMP.TB00012_NUM AS VARCHAR) NumEmp,
                  EMP.TB00012_COMP ComplementoEmp,
                  EMP.TB00012_BAIRRO BairroEmp,
                  EMP.TB00012_CEP CEPEmp,
                  CONCAT(EMP.TB00012_CIDADE,'/',EMP.TB00012_ESTADO) CidadeUFEmp,
                  TB02111_CODIGO Contrato,
                
                  --CLIENTE
                  TB01001_NOME NomeCli,
                  TB01001_CNPJ CNPJCli,
                  TB01001_INSCEST InscricaoEstCli,
                  CLI.TB00012_END RuaCli,
                  CAST(CLI.TB00012_NUM AS VARCHAR) NumCli,
                  CLI.TB00012_COMP ComplCli,
                  CLI.TB00012_BAIRRO BairroCli,
                  CLI.TB00012_CEP CEPCli,
                  CONCAT(CLI.TB00012_CIDADE,'/',CLI.TB00012_ESTADO) CidadeUFCli
              
              
              FROM TB02030
              LEFT JOIN TB01007 ON TB01007_CODIGO = TB02030_CODEMP
              LEFT JOIN TB00012 EMP ON EMP.TB00012_CODIGO = TB02030_CODEMP AND EMP.TB00012_TABELA = 'TB01007' AND EMP.TB00012_TIPO = '01'
              LEFT JOIN TB00012 CLI ON CLI.TB00012_CODIGO = TB02030_CODFOR AND CLI.TB00012_TABELA = 'TB01001' AND CLI.TB00012_TIPO = '01'
              LEFT JOIN TB02111 ON TB02111_CODIGO = TB02030_CONTRATO
              LEFT JOIN TB02176 ON TB02176_CODIGO = TB02030_CODSITE 
              LEFT JOIN TB02185 ON TB02185_CONTRATO = TB02111_CODIGO
              LEFT JOIN TB01001 ON TB01001_CODIGO = TB02030_CODFOR
              WHERE 
                TB02030_OPCOM = '01'
                AND TB02030_CODIGO = '$cod'
          
        ";
      $stmt = sqlsrv_query($conn, $sql);
        
        if($stmt === false)
        {
          die (print_r(sqlsrv_errors(), true));
        }
      ?>            
      <table class="table table-borderless table-sm" style="font-size: 11px;">
                  
      <?php
      $tabela = "";

      while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
                          /* $row[NomeCli], com inscrição no CNPJ nº $row[CNPJCli], IE nº $row[InscricaoEstCli],
                            localizado na $row[RuaCli], $row[NumCli], bairro $row[BairroCli], CEP $row[CEPCli], na cidade de
                            $row[CidadeUFCli], declara ter recebido o Equipamento Enviado, denominado Impressora, em perfeito
                            estado de conservação e funcionamento, conforme teste realizado, e que haverá zelo pela integridade física
                            do equipamento de propriedade de $row[NomeEmp], equipamento este que
                            será destinado ao atendimento do Contrato de Locação de Bens Móveis número: $row[Contrato]. */

      {
            $tabela .= "<tr>";
            $tabela .= "<td width = '60%;'>
                            $row[NomeEmp], inscrita no CNPJ sob o nº $row[CNPJEmp], InscriçãoEstadual n° $row[InscricaoEstEmp], 
                            localizada em $row[RuaEmp], $row[NumEmp], Bairro $row[BairroEmp], CEP $row[CEPEmp], na
                            cidade de $row[CidadeUFEmp], declara ter RECOLHIDO o equipamento denominado Impressora, de
                            propriedade de $row[NomeEmp], conforme dados abaixo:
                        </td>";
            $tabela .= "</tr>";

            $cidade = $row['CidadeUFCli'];
      }
        $tabela .= "</table>";
        
      print($tabela);
      ?>  
</div>                                                     
<div class="meio">
  <div class="dadosprod">
   <?php
        $sql = " 
            SELECT DISTINCT
                TB02208_NUMSERIE NumSerie,
                TB02030_CODIGO Pedido,
                TB01010_NOME Equipamento,
                TB02054_PAT Patrimonio,
                TB02176_END EndEquip,
                TB02031_PRODUTO Produto,
                COALESCE(
                          (SELECT TOP 1 
                            TB02122_CONTADOR 
                          FROM 
                            TB02122 
                          WHERE TB02122_PRODUTO = TB02208_PRODUTO 
                          AND TB02122_NUMSERIE = TB02208_NUMSERIE 
                          ORDER BY TB02122_DATA DESC),
                TB02054_MEDIDORPB) LeituraInicial,
                TB02111_CODIGO Contrato
              
              
            FROM TB02030
              LEFT JOIN TB02031 ON TB02031_CODIGO = TB02030_CODIGO 
              LEFT JOIN TB01007 ON TB01007_CODIGO = TB02030_CODEMP
              LEFT JOIN TB00012 EMP ON EMP.TB00012_CODIGO = TB02030_CODEMP AND EMP.TB00012_TABELA = 'TB01007' AND EMP.TB00012_TIPO = '01'
              LEFT JOIN TB00012 CLI ON CLI.TB00012_CODIGO = TB02030_CODFOR AND CLI.TB00012_TABELA = 'TB01001' AND CLI.TB00012_TIPO = '01'
              LEFT JOIN TB02111 ON TB02111_CODIGO = TB02030_CONTRATO
              LEFT JOIN TB01010 ON TB01010_CODIGO = TB02031_PRODUTO
              LEFT JOIN TB02208 ON TB02208_PRODUTO = TB02031_PRODUTO AND TB02208_PEDIDO = TB02030_CODIGO
              LEFT JOIN TB02055 ON TB02055_PRODUTO = TB02208_PRODUTO AND TB02208_PEDIDO = TB02055_CODIGO AND TB02055_OPERACAO = 'S' AND TB02055_NUMSERIE = TB02208_NUMSERIE
              LEFT JOIN TB02176 ON TB02176_CODIGO = TB02030_CODSITE 
              LEFT JOIN TB02054 ON TB02054_PRODUTO = TB02208_PRODUTO AND TB02054_NUMSERIE = TB02208_NUMSERIE
              LEFT JOIN TB01001 ON TB01001_CODIGO = TB02030_CODFOR
              LEFT JOIN TB02115 ON TB02115_PRODUTO = TB02115_PRODUTO AND TB02115_NUMSERIE = TB02208_NUMSERIE
            WHERE 
              TB02030_OPCOM = '01'
              AND TB02030_CODIGO = '$cod' 
        ";
      $stmt = sqlsrv_query($conn, $sql);
        
        if($stmt === false)
        {
          die (print_r(sqlsrv_errors(), true));
        }
      ?>

    <table class="table table-borderless table-sm" style="font-size: 11px;">
      <?php
      $tabela = "";

      while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
      {
            $tabela .= "<tr>";
            $tabela .= "<td width = '60%;'><b>Equipamento: </b>&nbsp;".$row['Equipamento']."</td>";
            $tabela .= "</tr>";
            $tabela .= "<tr>";
            $tabela .= "<td width = '60%;'><b>Patrimônio: </b>&nbsp;".$row['Patrimonio']."</td>";
            $tabela .= "</tr>";
            $tabela .= "<tr>";
            $tabela .= "<td width = '60%;'><b>Nº de Série: </b>&nbsp;".$row['NumSerie']."</td>";
            $tabela .= "</tr>";
            $tabela .= "<tr>";
            $tabela .= "<td width = '60%;'><b>Local de Instalação: </b>&nbsp;".$row['EndEquip']."</td>";
            $tabela .= "</tr>";
            $tabela .= "<tr>";
            $tabela .= "<td width = '60%;'><b>Leitura Inicial: </b>&nbsp;".$row['LeituraInicial']."</td>";
            $tabela .= "</tr>";
            $tabela .= "<tr>";
            $tabela .= "<td width = '60%;'><b>Medidor </b></td>";
            $tabela .= "</tr>";
                          $sql1 = " 
                          SELECT DISTINCT
                                    TB01049_TIPORATEIO TipoRateio,
                                    TB02030_CODIGO Venda,
                                    TB02111_CODIGO Contrato,
                                    TB01010_NOME Equipamento,
                                    TB02208_NUMSERIE NumSerie,
                                    TB02176_END EndEquip,
                                    COALESCE(TB02111_FRANQPB, TB02111_FRANQCOLOR, TB02111_FRANQGF, TB02111_FRANQGFC, TB02111_FRANQDG) Paginas,
                                    FORMAT(                              
                                            CASE
                                            WHEN TB02111_ANALFRANQUIA = 'T' THEN TB02113_VALOR
                                            WHEN TB02111_ANALFRANQUIA = 'M' THEN TB02113_VALOR
                                            WHEN TB02111_ANALFRANQUIA = 'G' THEN TB02186_VALOR
                                            END, 'C', 'pt-br') valor, 
                                                                      
                                                                      
                                        TB02113_VALOR Excedente,
                                                                      
                                    TB01049_NOME Franquia,
                                    TB01049_VARIAVEL TipoCobertura
                                    
                                                                      
                                                                      
                                    FROM TB02030
                                    LEFT JOIN TB02031 ON TB02031_CODIGO = TB02030_CODIGO 
                                    LEFT JOIN TB01007 ON TB01007_CODIGO = TB02030_CODEMP
                                    LEFT JOIN TB01001 ON TB01001_CODIGO = TB02030_CODFOR
                                    LEFT JOIN TB00012 EMP ON EMP.TB00012_CODIGO = TB02030_CODEMP AND EMP.TB00012_TABELA = 'TB01007' AND EMP.TB00012_TIPO = '01'
                                    LEFT JOIN TB00012 CLI ON CLI.TB00012_CODIGO = TB02030_CODFOR AND CLI.TB00012_TABELA = 'TB01001' AND CLI.TB00012_TIPO = '01'
                                    LEFT JOIN TB02111 ON TB02111_CODIGO = TB02030_CONTRATO
                                    LEFT JOIN TB02112 ON TB02112_CODIGO = TB02111_CODIGO AND TB02112_PRODUTO = TB02031_PRODUTO
                                    LEFT JOIN TB01010 ON TB01010_CODIGO = TB02031_PRODUTO
                                    LEFT JOIN TB02208 ON TB02208_PRODUTO = TB02031_PRODUTO AND TB02208_PEDIDO = TB02030_CODIGO
                                    LEFT JOIN TB02055 ON TB02055_PRODUTO = TB02208_PRODUTO AND TB02208_PEDIDO = TB02055_CODIGO AND TB02055_OPERACAO = 'S' AND TB02055_NUMSERIE = TB02208_NUMSERIE
                                    LEFT JOIN TB02176 ON TB02176_CODIGO = TB02030_CODSITE 
                                    LEFT JOIN TB02054 ON TB02054_PRODUTO = TB02112_PRODUTO AND TB02054_NUMSERIE = TB02112_NUMSERIE
                                    LEFT JOIN TB02115 ON TB02115_CONTRATO = TB02030_CONTRATO AND TB02115_PRODUTO = TB02031_PRODUTO AND TB02115_NUMSERIE = TB02112_NUMSERIE
                                    LEFT JOIN TB02113 ON TB02113_PRODUTO = TB02112_PRODUTO AND TB02113_NUMSERIE = TB02208_NUMSERIE AND TB02113_CODIGO = TB02112_CODIGO
                                    LEFT JOIN TB01049 ON TB01049_CODIGO = TB02113_COBERTURA
                                    LEFT JOIN TB02185 ON TB02185_CONTRATO = TB02111_CODIGO
                                    LEFT JOIN TB02186 ON TB02186_GRUPO = TB02112_GRUPO AND TB02186_COBERTURA = TB02113_COBERTURA
                                    WHERE  
                                      TB02030_OPCOM = '01'
                                      AND TB02208_NUMSERIE = '$row[NumSerie]'
                                      AND TB02111_CODIGO = '$row[Contrato]'
                                      AND TB02030_CODIGO = '$row[Pedido]'
                                  ";
                              $stmt1 = sqlsrv_query($conn, $sql1);
                                
                              while ($row1 = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC))
                              {
                                $franquia = $row1['Franquia']." ";
                                $paginas = $row1['Paginas']." Páginas ";
                                $vlrPaginas = $row1['Franquia']." " .$row1['valor'];
                                $excedente = $row1['Franquia']." " .$row1['valor']." por página excedente";
                                $valor = $row1['valor'];


                                if($row1['TipoCobertura'] == 'N' && $row1['TipoCobertura'] >= 0 && $row1['TipoRateio'] != 4){
                                  $textoMedidor = $franquia." ".$paginas."Valor: ".$valor;
                                }
                                  elseif($row1['TipoCobertura'] == 'E'){
                                    $textoMedidor = $excedente;
                                  }
                                    elseif($row1['TipoCobertura'] == 'S'){
                                      $textoMedidor = $vlrPaginas." por página.";
                                    }
                                      elseif($row1['TipoCobertura'] == 'N' && $row1['TipoRateio'] == 4){
                                          $textoMedidor = $vlrPaginas;
                                      }


                                    $tabela .= "<tr>";
                                    $tabela.= "<td>&nbsp; $textoMedidor </td>";
                                    $tabela.= "</tr>";
                              } 
              /* $tabela .= "<tr><td></td></tr>  <tr><td></td></tr>  <tr><td></td></tr>"; */                               
      }
        $tabela .= "</table>";
        
      print($tabela);
    ?> 
  </div>
  
  <div class="info-central">
    <div class='info'><?php echo $cidade;?>, <?php echo date('d/m/Y'); ?></div>
  </div>

<hr> <!-- LINHA CENTRAL -->

   <div class="table-assin">                            
      <table>
        <thead>
          <tr>
            <th>Contratante</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Nome: _______________________________</td>
          </tr>
          <tr><td> </td></tr>
          <tr><td> </td></tr>
          <tr><td> </td></tr>
          <tr>
            <td>CPF: ________________________________</td>
          </tr>
          
        </tbody>
      </table>

      <table>
        <thead>
          <tr>
            <th>Contratada</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Nome: _______________________________</td>
          </tr>
          <tr><td> </td></tr>
          <tr><td> </td></tr>
          <tr><td> </td></tr>
          <tr>
            <td>CPF: ________________________________</td>
          </tr>
          
        </tbody>
      </table>
  </div> 

   <table class="table table-border table-sm" style="font-size: 11px;">

   </table>
   <div class="partedebaixo">
        <div class="dizeres-finais">
          <p>
            Observações:
            Se houver necessidade do técnico imprimir páginas de teste no equipamento enviado, ele poderá fazê-lo.
            Em caso de solicitação de dedução das páginas teste impressas pelo técnico, estas serão descontadas.
            Solicito o desconto de ________ página(s) impressa(s) utilizadas para teste.
          </p>
        </div>
          <div class="table-assin2">                            
              <div>_________________________________________</br><b class="assin">Cliente</b></div>
                &nbsp;
              <div>_________________________________________</br><b class="assin">Técnico Responsável</b></div>
                &nbsp;
          </div> 
  </div> 
</div>
</body>
</html>
