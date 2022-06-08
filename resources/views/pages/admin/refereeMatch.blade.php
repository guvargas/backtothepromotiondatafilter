@extends('layouts.page')

@section('content')
<header>
  <button>BACK</button>
  <span>BadMint</span>
</header>

<main>
  <div class="timetable">
    <span>Tempo de jogo:</span> <span class="timer"><strong>00:00</strong></span>
  </div>
  <button class="warning">Finalizar jogo!</button>

  <div class="scorecard">
    <p class="time">
      UDESC 1
      <br />
      <span class="left">01</span>
    </p>
    <p class="time">
      UDESC 2
      <br />
      <span class="right">00</span>
    </p>
  </div>

  <div class="court">
    <button class="left-court">
      QUADRA 01
    </button>
    <button class="right-court">
      QUADRA 02
    </button>
  </div>

  <div class="court-command">
    <button class="add-score left-score">
      +1
    </button>
    <div class="undo-card">
      <button> Desfazer </button>
    </div>
    <button class="add-score right-score">
      +1
    </button>
  </div>

  <div class="game-control">
    <button class="pause">
      Pausar
    </button>
    <button>
      Intervalo
    </button>
  </div>


</main>


@endsection

@section('script')

<script src="https://www.gstatic.com/firebasejs/3.7.4/firebase.js"></script>

<script>
  //classe que pq a gente gosta de orientacao objeto
  class Sete {
    constructor(left, right) {
      this.left = left;
      this.right = right;
    }
  }
  
  // PONTUACAO
  let leftScore = 0;
  let rightScore = 0;

  let setAtual = 0;

  let setsJogados = [
    new Sete([], []),
    new Sete([], []),
    new Sete([], [])
  ];

  

  //FETCHING BUTTONS
  const endGameButton = document.querySelector('.warning')
  endGameButton.id = 'active'
  endGameButton.innerHTML = 'Iniciar jogo!'

  const leftTeam = document.querySelector('.time span.left')
  leftTeam.innerHTML = leftScore

  const rightTeam = document.querySelector('.time span.right')
  rightTeam.innerHTML = rightScore

  const addLeftButton = document.querySelector('.left-score')
  const addRightButton = document.querySelector('.right-score')

  const leftCourtButton = document.querySelector('.left-court')
  const rightCourtButton = document.querySelector('.right-court')


  let leftWinningSets = 0;
  let rightWinningSets = 0;

  let canCall = true

  let hasGameEverStarted = false

  let isGameStarted = false;
  let isPaused = false;
  let intervalId = 0

  const endGame = () => {
    
    if (!isPaused) {
      hasGameEverStarted = true

      endGameButton.id = ' '
      endGameButton.innerHTML = 'Finalizar jogo!'

      isGameStarted = !isGameStarted

      if (isGameStarted) {
        intervalId = setInterval(updateTimer, 1000)
        console.log('Timer iniciou')
      } else {
        endGameButton.id = 'active'
        endGameButton.innerHTML = 'Iniciar jogo!'
        
        clearInterval(intervalId)

        resetVariables()

        console.log('Timer foi encerrado')
      }
    }
  }



  
  const verifyBreakTimeByPoints = () =>{
    if(leftScore == 11 || rightScore == 11){
      pauseGame()
      canCall = false
      hasGameEverStarted = false

      //1 minuto
      setTimeout(() => {
        hasGameEverStarted = true
        pauseGame()
        
      }, 60000);
    }
  }

  const verifyBreakTimeBySets = (acabouSet) => {
    console.log('Espera 2 minutos ai pf!');
    if(acabouSet){

      pauseGame()
      hasGameEverStarted = false

      //2 minutos
      setTimeout(() => {
        hasGameEverStarted = true
        pauseGame()
      }, 120000);
    }
  }

  const verificaSet = () => {
    let acabouEsteSet = false;

    if(setAtual != 2){
      //left won this set
      if (setsJogados[setAtual].left.length == 21 && setsJogados[setAtual].right.length < setsJogados[setAtual].left.length - 1) {
        leftWinningSets++;
        acabouEsteSet = true;
      }

      //right won this set
      if (setsJogados[setAtual].right.length == 21 && setsJogados[setAtual].left.length < setsJogados[setAtual].right.length - 1) {
        rightWinningSets++;
        acabouEsteSet = true;
      }
    }


    //left won this set
    if (setsJogados[setAtual].left.length == 30) {
      leftWinningSets++;
      acabouEsteSet = true;
    }

    //right won this set
    if (setsJogados[setAtual].right.length == 30) {
      rightWinningSets++;
      acabouEsteSet = true;
    }

    //caso nao seja o ultimo set do jogo (terceiro set) e este set acabou
    if (acabouEsteSet && setAtual != 2) {

      verifyBreakTimeBySets(acabouEsteSet)

      setAtual++;
      leftScore = 0;
      leftTeam.innerHTML = leftScore;
      rightScore = 0;
      rightTeam.innerHTML = rightScore;

      canCall = true
    }


    //caso seja o ultimo set do jogo
    if (leftWinningSets >= 2 || rightWinningSets >= 2) {
      console.log('Jogo acabou');

      
      endGame()

      //A função só pode ser chamada se o isPaused = false, ou seja, a partida não está pausada. Por isso vamos pausar para que o método não seja chamado novamente.
      //O endGame() chama o resetVariables(), que torna isPaused = false e hasGameEverStarted = false. Se o jogo está pausado ele n pode ser terminado/iniciado e se ele não
      //está iniciado ele não pode ser pausado/despausado, logo iremos pausar forçadamente para interromper o fluxo inteiro (gambiarra?) 
      isPaused = true
      

      

      return false;
    }



    return true;

  }

  

  const addPointsLeft = () => {
    console.log('MEUSDEUS') 

    if(hasGameEverStarted && !isPaused){

      if (verificaSet()) {
        setsJogados[setAtual].left.push(Date.now());
        leftScore += 1;
        leftTeam.innerHTML = leftScore;

        if(canCall){
          console.log('Agora o jogo esta pausado por 11 pontos');
          verifyBreakTimeByPoints()
        }
        savePonto();

        verificaSet()
      }
    }
  }

  const addPointsRight = () => {
    if( hasGameEverStarted && !isPaused){
 
      if (verificaSet()) {
        setsJogados[setAtual].right.push(Date.now());
        rightScore += 1;
        rightTeam.innerHTML = rightScore;

        if(canCall){
          verifyBreakTimeByPoints()
        }
        savePonto();

        verificaSet()
      }
    }
  }

  addLeftButton.addEventListener('click', addPointsLeft)
  addRightButton.addEventListener('click', addPointsRight)

  leftCourtButton.addEventListener('click', addPointsLeft)
  rightCourtButton.addEventListener('click', addPointsRight)

  // CRONOMETRO
  let time = 0
  const timerTag = document.querySelector('.timer')

  const updateTimer = () => {
    time++
    let minutes = Math.floor(time / 60)
    let seconds = time % 60
  
    if (seconds < 10) {
      timerTag.innerHTML = `0${minutes}:0${seconds}`
    } else {
      timerTag.innerHTML = `0${minutes}:${seconds}`
    }
  }

 

  

 

  const resetVariables = () => {
    time = 0
    hasGameEverStarted = false

    leftScore = 0;
    leftTeam.innerHTML = leftScore;
    rightScore = 0;
    rightTeam.innerHTML = rightScore;

    leftWinningSets = 0;
    rightWinningSets = 0;

    setAtual = 0

    isGameStarted = false;
    isPaused = false;
    intervalId = 0
    canCall = true

  }

 

  endGameButton.addEventListener('click', endGame )

  const pauseButton = document.querySelector('.pause')

  const pauseGame = () => {
    if (hasGameEverStarted) {

      isPaused = !isPaused
      isGameStarted = !isGameStarted

      if (isGameStarted) {
        intervalId = setInterval(updateTimer, 1000)
      } else {
        clearInterval(intervalId)
      }
    }
  }

  pauseButton.addEventListener('click', pauseGame)

  //SYNC FIREBASE
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
  const database = firebase.database()


  const partidas = database.ref('Lista de Partidas')

  var newPartidaReference = partidas.push();

  function savePonto() {

    newPartidaReference.set(setsJogados);

  }




  
</script>

@endsection

@section('style')
<style>
  * {
    box-sizing: border-box;
    border: none;
    outline-style: none;
    text-decoration: none;

    margin: 0;
    padding: 0;
  }

  :root {
    font-size: 62.5%;
  }

  body {
    height: 100vh;
    font-size: 1.4rem;
  }

  header {
    height: 8rem;

    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin-left: 1rem;
  }

  header>button {
    margin-right: .5rem;
  }

  header>span {
    font-size: 3rem;
  }

  main {
    width: 30rem;
    margin: 0 auto;

    text-align: center;
  }

  div.timetable {
    font-size: 1.8rem;
  }

  button.warning {
    width: 16rem;
    height: 4rem;

    margin-top: 3rem;

    border-radius: 1.2rem;
    background-color: red;

    font-size: 1.8rem;
    font-weight: 700;
    color: white;
  }

  div.scorecard {
    display: flex;

    justify-content: center;
    gap: .5rem;

    background: #FFFF;

    margin: 3rem 0 auto auto;
    margin-left: auto;
    margin-right: auto;
  }

  div.scorecard>p.time {
    width: 14rem;
    height: 4.5rem;

    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    border-radius: 1rem;
    box-shadow: 0 0.5rem 3rem rgba(0, 0, 0, 0.4);


    font-size: 1.8rem;
    font-weight: 700;

  }

  div.court {
    background-color: green;
    height: 15rem;

    margin-top: 1rem;
  }

  div.court>button {
    height: 100%;
    width: 12rem;
  }

  div.court-command {
    height: 10rem;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;

    margin-top: 2rem;
  }

  button.add-score {
    height: 50%;
    width: 6rem;

    border-radius: 1.2rem;

    font-size: 2.5rem;
    font-weight: 700;
    color: white;
    background-color: green;
  }

  div.undo-card {
    height: 100%;
    width: 13rem;

    display: flex;
    align-items: flex-end;

    /* background-color: blue; */
  }

  div.undo-card>button {
    height: 50%;
    width: 100%;

    border-radius: 1.2rem;
    box-shadow: 0 0.5rem 3rem rgba(0, 0, 0, 0.4);

    font-size: 1.8rem;
    font-weight: 700;
  }

  div.game-control {
    height: 5rem;

    display: flex;
    justify-content: center;
    gap: 2rem;

    margin-top: 4rem;
  }

  div.game-control>button {
    width: 13rem;

    border-radius: 1.2rem;

    font-size: 1.8rem;
    font-weight: 700;
  }

  div.game-control>button:nth-last-of-type(1) {
    background-color: blue;
    color: white;
  }

  #active {
    background-color: green;
  }
</style>
@endsection
