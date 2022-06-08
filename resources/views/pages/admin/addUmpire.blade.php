@extends('layouts.admin')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-5 mt-5">Adicionar árbitro à campeonato</h1>
            <form class="form-control">
                <div class="row">
                    <div class="input-group mb-5 mx-auto">
                        <label class="input-group-text" for="championships">Campeonatos</label>
                        <select class="form-select" id="championships">
                        </select>
                    </div>
                    <div class="input-group mb-5 mx-auto">
                        <label class="input-group-text" for="fname">Nome Completo</label>
                        <input class="form-control" type="text" id="fname" name="fname">
                    </div>
                    <div class="input-group mb-5 mx-auto  justify-content-center">
                        <div onclick="enviarPraFirebase()" class="btn btn-primary mb-3">Cadastrar Árbitro</div>
                    </div>
                </div>
            </form>
            <ul class="list-group list-group-flush mb-5 mt-5" id="umpireList" class="list-group list-group-flush"></ul>

        </div>
    </div>
</div>
@endsection


@section('script')
<script src="https://www.gstatic.com/firebasejs/3.7.4/firebase.js"></script>
<script>
    var arrayCampeonatos = [];
    var arrayArbitros = [];

    const firebaseConfig = {
        apiKey: "AIzaSyBQB0_U9l4H3IA5RijPMW5R5ID6zHrR6gY",
        authDomain: "badmint-670a4.firebaseapp.com",
        databaseURL: "https://badmint-670a4-default-rtdb.firebaseio.com",
        projectId: "badmint-670a4",
        storageBucket: "badmint-670a4.appspot.com",
        messagingSenderId: "559029197625",
        appId: "1:559029197625:web:5edfc7750a4e7ac3c5e6e8",
        measurementId: "G-SGSVJW0RM6"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    // const analytics = getAnalytics(app);

    const umpireReference = firebase.database().ref('Lista Arbitros');
    const listaCampeonatosReference = firebase.database().ref('Lista de Campeonatos');


    function enviarPraFirebase() {
        var nomeArbitro = document.getElementById("fname").value;
        var nomeCampeonato = document.getElementById("championships").value;

        if (nomeArbitro == "" || nomeCampeonato == "" || nomeArbitro == null || nomeCampeonato == "Selecione um campeonato") {
            alert("Preencha todos os campos!");
        }
        saveUmpire(nomeArbitro, nomeCampeonato);

    }

    // Save message to firebase
    function saveUmpire(nome, campeonato) {
        var newUmpireRef = umpireReference.push();
        newUmpireRef.set({
            nome: nome,
            campeonato: campeonato,
        });
        getUmpires();
    }

    function getCampeonatos() {
        arrayCampeonatos = [];
        listaCampeonatosReference.on("value", function(snapshot) {
            snapshot.forEach(function(childSnapshot) {
                var childData = childSnapshot.val();
                arrayCampeonatos.push(childData);
            });
            preencherListaNaTela();
        });

    }


    function preencherListaNaTela() {
        var listCampeonatos = document.getElementById("championships");
        var option = document.createElement("option");
        option.text = 'Selecionar o campeonato :)';
        option.value = null;
        listCampeonatos.options.add(option, 0);
        for (var i = 0; i < arrayCampeonatos.length; i++) {
            option = document.createElement("option");
            option.text = arrayCampeonatos[i].nome;
            option.value = arrayCampeonatos[i].id;
            listCampeonatos.options.add(option, i + 1);
        }
    }

    getCampeonatos();
    getUmpires();

    function getUmpires() {
        arrayArbitros = [];
        umpireReference.on("value", function(snapshot) {
            snapshot.forEach(function(childSnapshot) {
                var childData = childSnapshot.val();
                arrayArbitros.push(childData);
            });
            preencherListaArbitrosNaTela();
        });
    }

    function preencherListaArbitrosNaTela() {
        var listUmpire = document.getElementById("umpireList");
        listUmpire.innerHTML = "";
     
        arrayArbitros.forEach(element => {
            var umpire = document.createElement("LI");
            umpire.className = "list-group-item";
            umpire.innerText = element.nome;
            listUmpire.appendChild(umpire);
        });
    }
</script>

@endsection