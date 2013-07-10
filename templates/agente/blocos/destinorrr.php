<div class="boxTabs">
        <div class="tabbable"> <!-- Only required for left/right tabs -->
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">Crie o seu destino</a></li>
            <li class="d"><a href="#tab2" data-toggle="tab">Para onde Ir</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab1">
              <div class="tabFormulario">
                <h3>O que você deseja cotar para sua viagem?</h3>
                <form action="vars.php" method="post" class="form-inline">
                  <div class="controls controls-row">
                    <label class="checkbox inline">
                      <input type="checkbox" id="inlineCheckbox1" value="option1">
                      Aéreo </label>
                    <label class="checkbox inline">
                      <input type="checkbox" id="inlineCheckbox2" value="option2">
                      Hotel </label>
                    <label class="checkbox inline">
                      <input type="checkbox" id="inlineCheckbox3" value="option3">
                      Aluguel de carro </label>
                    <label class="checkbox inline">
                      <input type="checkbox" id="inlineCheckbox3" value="option3">
                      Atividades Locais </label>
                  </div>
                  <h2>Roteiros e dadas</h2>
                  <div class="controls controls-row tipoRdio">
                    <label class="inline"> 
                      <input class="inline" type="radio" value="ida_volta" >
                      Ida e Volta
                      <input class="inline" type="radio" value="ida">
                        Somente Ida
                    </label>
                  </div>
                    <div class="bloAjudaMe" style="height:;">      
                          <div class="camp1">
                            <label>
                              <input class="deViagem" type="text" placeholder="De">
                            </label>
                            <label>Data de Partida
                              <input class="selecDate" type="text" placeholder="dd/mm/aa">
                            </label>
                          </div>
                          
                          <div class="camp2">
                            <label>
                              <input class="paraViagem" type="text" placeholder="Para">
                            </label>
                            <label> Qtde de Noites
                              <select class="qtdViagem">
                                <option>Selecione</option>
                                <option>2</option>
                              </select>
                            </label>
                          </div>  
                   </div>       
                  <span class="linkOutroDestino"><a href="#"> + Adicionar outro destino</a></span>
                  <div class="selectSpan1">
                    <div class="coluSpan1"> <span>Adultos</span>
                      <select class="select1">
                        <option>Selecione</option>
                        <option>2</option>
                      </select>
                    </div>
                    <div class="coluSpan2"> <span>De 0 a 23 meses</span>
                      <select class="select2">
                        <option>Selecione</option>
                        <option>2</option>
                      </select>
                    </div>
                    <div class="coluSpan3"> <span>Crianças de 2 a 12 anos</span>
                      <select class="select3">
                        <option>Selecione</option>
                        <option>2</option>
                      </select>
                    </div>
                  </div>
                  <textarea cols="60" rows="5" id=""  class="msgTxtHome"name=""  placeholder="Deixe seu comentário, observações e o que mais desejar :)" ></textarea>
                  <button class="btn btn-rky" type="button">Adicionar destino</button>
                </form>
              </div>
              <!-- Fecha tab Formulário--> 
            </div>
            <div class="tab-pane" id="tab2">
              <div>
                <p>Para onde Ir</p>
              </div>
            </div>
          </div>
        </div>