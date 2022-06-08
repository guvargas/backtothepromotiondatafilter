@extends('layouts.admin')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- <form class="row g-3" action="/import" method="POST" > -->
            <form class="row g-3">
                <h1 class="mb-5 mt-5">Importar Dados</h1>
                
                <div class="mb-3">
                    <label for="formFile" class="form-label">Arquivo com dados de partidas</label>
                    <input class="form-control" type="file" id="formFile">
                </div>

                <div class="col-auto">
                    <div class="input-group mb-5 mx-auto  justify-content-center">
                        <div onclick="parseFile()" class="btn btn-primary mb-3">Importar</div>
                    </div>
                </div>
            </form>
            <h3 id="eventoNome" class="mt-5 mb-1"></h3>
            <h5 id="eventoData" class="mb-2"></h5>
            <ul class="list-group list-group-flush mb-5" id="listaPartidas"></ul>
        </div>
    </div>
</div>
@endsection


@section('script')
<script src="https://www.gstatic.com/firebasejs/3.7.4/firebase.js"></script>
<script>

    class Evento{
        constructor(nome,partidas, data){
            this.nome = nome;
            this.partidas = partidas;
            this.data = data;
        }
    }
    class Time{
        constructor(nomesTime){
            var nomesNormalizado = nomesTime.normalize();
            this.nomeJogadorA = null;
            this.nomeJogadorB = null;
            var nomes = [];
            // in case they change the splitter from '+' to another char, use regex to match the names
            let re = new RegExp('([a-zA-Z\u00c0-\u024f\u1e00-\u1eff\\s]+(\\[\\d+\\])*){1}(\\W)*([a-zA-Z\u00c0-\u024f\u1e00-\u1eff\\s]+(\\[\\d+\\])*){0,1}');
            let timesMatch = re.exec(nomesNormalizado);
            
            //tries the pattern known in case the regex fails
            if (timesMatch.length == 0 || timesMatch == null){
                nomes = nomesNormalizado.split('+');
            }
            else{
                nomes[0] = timesMatch[1];
                if(timesMatch[4]!=null && timesMatch[4] !== '')
                    nomes[1] = timesMatch[4];
            }


            if (nomes.length >= 1) 
                this.nomeJogadorA = nomes[0];
            if (nomes.length == 2)
                this.nomeJogadorB = nomes[1];
        }

    }
    class Match{
        constructor(dataHora,categoria,timeA,timeB){
            this.dataHora = dataHora;
            this.categoria = categoria;
            this.timeA = timeA;
            this.timeB = timeB;
        }
    }
    
    function parseFile(){
        const f = document.getElementById("formFile").files[0];
        if (f == null){
            alert("Insira um arquivo!");
            return;
        }
        var reader = new FileReader();
        var nome = f.nome;
        reader.onload = function(e) {
            //leitura do arquivo xls
            const fileData = e.target.result;
            const workbook = xlsx.read(fileData, {type: 'binary'});
            const sheetNames = workbook.SheetNames;
            //lê primeira planilha do arquivo
            const dados = xlsx.utils.sheet_to_json(workbook.Sheets[sheetNames[0]]);

            //pelo formato do arquivo, a primeira céula da 1ª coluna se torna o cabeçalho dessa coluna, por isso nome do campeonato é chave em todos objetos (linhas), 
            //e as seguintes colunas estão vazias e por isso seus cabeçalhos/chaves aparecem como *EMPTY
            const key = Object.keys(dados[0])[0];
            partidas = [];
            evento = new Evento(key,partidas,dados[0][key]);

            const categoriaKey = '__EMPTY';
            const timeAKey = '__EMPTY_1';
            const timeBKey = '__EMPTY_2';
            for (let i = 3; i < dados.length; i++ ){
                timeA = new Time(dados[i][timeAKey]);
                timeB = new Time(dados[i][timeBKey]);
                categoria = dados[i][categoriaKey];
                dataHora = dados[i][key];
                let matchObj = new Match(dataHora,categoria,timeA,timeB);
                
                evento.partidas.push(matchObj);
            };
            mostraListaDadosLidos(evento);
        };
        reader.readAsBinaryString(f);

        
    }
    
    function mostraListaDadosLidos(evento) {
        console.log(evento);
        var nomeEvento = document.getElementById("eventoNome");
        nomeEvento.innerText = evento.nome;
        var dataEvento = document.getElementById("eventoData") ;
        dataEvento.innerText = evento.data;
        
        var lista = document.getElementById("listaPartidas");
        lista.innerHTML = "";
        
        evento.partidas.forEach(partida => {
            var li = document.createElement("LI");
            li.className = "list-group-item";
            li.innerText = JSON.stringify(partida);
            lista.appendChild(li);
        });
    }
</script>

@endsection