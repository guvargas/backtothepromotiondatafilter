@extends('layouts.page')
@section('title', 'Bem-vindo')
@section('description', 'Aqui vamos ler os dados do caminho feito pelo jogador sobre o jogo backtothepromotion')

@section('content')

<div class="container">
    <div class="row">
        <center>
            <div class="col">
                <div class="jumbotron">
                    <h1>Aqui vamos ler os dados do caminho feito pelo jogador sobre o jogo backtothepromotion</h1>
                    <div onclick="dale()" class="btn btn-primary mb-3">Fazer Pesquisa</div>
                </div>
                <p id="Resultado"></p>
            </div>
        </center>
    </div>
</div>




@endsection

@section('script')
<script src='/js/personagens.js'></script>
<script src="/js/dados_alunos.js"></script>
<script>
   //let mix = require('laravel-mix');
 //   require('dotenv').config();

    function readJsonFile() {
        //galera do pc
        let IDS_PESQUISA =GALERA_DO_PC_UM;

        //galera
        //let IDS_PESQUISA = [2, 6, 18, 38, 37, 36, 27, 29, 1, 35, 13];

        let dados = JSON.parse(personagensData);
        let dadosFiltrados = [];
        let idatual = ""
        let count = 0;
        let personagens = ["PersonagemRecepcionista", "Diretora", "TeacherContainer", "PessoaArquibancada", "Arquibancada dois ", "Arbitro"];
        const mapaDeGente = new Map();
        const mapaDeFluxos = new Map();
        dados.forEach(element => {
            IDS_PESQUISA.forEach(id => {

                //se o id tiver dentre os alunso que a gente ta procurando
                if (element.id_aluno == id) {
                    //normalizar datas
                    var data = element.horario.replace('T', '-').replace('Z', '');
                    var dateParts = data.split("-");
                    var jsDate = new Date(Date.UTC(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0, 2), dateParts[3].substr(0, 2), dateParts[3].substr(3, 2), dateParts[3].substr(6, 2)));

                    //se o dia for igual ao dia que a gente quer saber dentre o horario que a gente quer ver
                    if ( jsDate.getDate() == 18 && jsDate.getHours() >= 19 && jsDate.getHours() <= 21) {
                        var arrayDesteAluno = [];
                        element.horario=jsDate;
                        //se o mapa ja tiver o id do aluno, pegar o array dele
                        if (mapaDeGente.has(element.id_aluno)) {
                            arrayDesteAluno = mapaDeGente.get(element.id_aluno);
                        }

                        //adicionar o objeto clicado no array do aluno
                        if (personagens.includes(element.objeto)) {
                            var jahExiste = false;
                            arrayDesteAluno.forEach(dadosDeCadaAluno => {
                                if (dadosDeCadaAluno.objeto == element.objeto) {
                                    //  jahExiste = true;
                                }
                            });
                            if (!jahExiste) {
                                arrayDesteAluno.push(element);
                            }
                        }
                        mapaDeGente.set(element.id_aluno, arrayDesteAluno);


                        // arrayDesteAluno.forEach(dadosDeCadaAluno => {
                        //     if (personagens.includes(dadosDeCadaAluno.objeto)) {
                        //         console.log(dadosDeCadaAluno);
                        //         dadosFiltrados.push(dadosDeCadaAluno);
                        //         dadosFiltrados = [
                        //             ...dadosFiltrados,
                        //             "id_aluno" => dadosDeCadaAluno.id_aluno,

                        //         ];
                        //     }
                        // });
                        // count++;
                    }
                }
            });
        });
        console.log(mapaDeGente);
    }
</script>
<script>
    readJsonFile();
</script>
@endsection


@section('style')
<style>
    label.input-group-text {
        background-color: rgb(42 160 81 / 21%);
        color: var(--color-primary);
    }

    .card {
        --bs-card-spacer-y: 2rem;
        --bs-card-spacer-x: 2rem;
        --bs-card-title-spacer-y: 0.5rem;
        --bs-card-border-width: 0;
        --bs-card-border-color: var(--bs-border-color-translucent);
        --bs-card-border-radius: 1.5rem;
        --bs-card-box-shadow: 3px 4px 26px rgb(5 20 10 / 8%);
        --bs-card-inner-border-radius: calc(0.375rem - 1px);
        box-shadow: var(--bs-card-box-shadow);
    }

    .scoreboard {
        font-weight: 700;
        font-size: 2em;
        background-color: rgb(92 102 112 / 18%);
        padding: 0.1em 0.4em;
        border-radius: 10px;
        color: #5c6670;
        margin-right: 0.4em;
        min-width: 70px;
        text-align: center;
    }

    .players {
        font-size: 1.4em;
        font-weight: 800;
        color: #5c6670;
    }

    .score-players {
        display: flex;
        align-items: center;
        margin-bottom: 3px;
    }

    .match:hover {
        transform: scale(1.05);
        --bs-card-bg: #2aa352;
        color: white !important;
    }

    .match:hover .badge {
        background-color: #b7d9c2 !important;
    }

    .match:hover .players {
        color: white;
    }

    .match:hover .scoreboard {
        color: white;
        background-color: #5c66707a;
    }
</style>
@endsection
