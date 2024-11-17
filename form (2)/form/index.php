<?php
    include('db.php');
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   
    <title>Snake game</title>
  </head>
  <style>
   @import url('https://fonts.googleapis.com/css2?family=New+Tegomin&display=swap');
* {
    padding: 0;
    margin: 0;
    --clr-neon: hsl(317 100% 54%);
}

body {
    background-image: url(bg9.png);
    min-height: 100vh;
    background-size: 100vw 100vh;
    background-repeat: no-repeat;
    display: flex;
    justify-content: center;
    align-items: center;
}
.button-container {
      position: absolute;
      top: 20px;
      right: 20px;
    }
    
button{
    background-color:teal;
    color: #000;
    radius:20px;
}

#board {
    width: 90vmin;
    height: 92vmin;
    box-shadow: 0 0 0.1vw 0.3vw #fff7f7, 0 0 3vw 0.3vw #7528d6, inset 0 0 1vw 0.3vw #7528d6, inset 0 0 0.3vw 0.1vw #fff7f7;
    border-radius: 10px;
    transform: translateX(82px);
    display: grid;
    grid-template-columns: repeat(18, 1fr);
    grid-template-rows: repeat(18, 1fr);
}

#scoreBox {
    position: absolute;
    top: 42px;
    right: 86px;
    font-size: 30px;
    font-weight: bold;
    font-family: 'New Tegomin', serif;
    color: #fff;
    font-family: 'Poppins', sans-serif;
    text-shadow: 0 0 0.125em var(--clr-neon), 0 0 0.45em currentColor;
}

#hiscoreBox {
    position: absolute;
    top: 95px;
    right: 37px;
    font-size: 30px;
    color: #fff;
    font-weight: bold;
    font-family: 'New Tegomin', serif;
    font-family: 'Poppins', sans-serif;
    text-shadow: 0 0 0.125em var(--clr-neon), 0 0 0.45em currentColor;
}

.head {
    background: linear-gradient(rgb(240, 124, 124), rgb(228, 228, 129));
    box-shadow: 0 0 0.1vw 0.3vw #fff7f7, 0 0 3vw 0.3vw #7528d6, inset 0 0 1vw 0.3vw #7528d6, inset 0 0 0.3vw 0.1vw #fff7f7;
    border: 2px solid rgb(34, 4, 34);
    transform: scale(1.02);
    border-radius: 9px;
}

.snake {
    box-shadow: 0 0 0.1vw 0.3vw #fff7f7, 0 0 3vw 0.3vw #d62828, inset 0 0 1vw 0.3vw #d62828, inset 0 0 0.3vw 0.1vw #fff7f7;
    border: .25vmin solid white;
    border-radius: 12px;
}

.food {
    box-shadow: 0 0 0.1vw 0.3vw #fff7f7, 0 0 3vw 0.3vw #d62828, inset 0 0 1vw 0.3vw #d62828, inset 0 0 0.3vw 0.1vw #fff7f7;
    border: .25vmin solid black;
    border-radius: 8px;
}

.ad {
    float: left;
    transform: translate(-453px, 5px);
    position: absolute;
    /* box-shadow: 0 0 0.1vw 0.3vw #fff7f7, 0 0 3vw 0.3vw #7528d6, inset 0 0 1vw 0.3vw #7528d6, inset 0 0 0.3vw 0.1vw #fff7f7; */
}

.te {
    box-shadow: 0 0 0.1vw 0.3vw #fff7f7, 0 0 3vw 0.3vw #7528d6, inset 0 0 1vw 0.3vw #7528d6, inset 0 0 0.3vw 0.1vw #fff7f7;
    transform: translate(0px, -51px);
    color: #fff;
    text-align: center;
    font-family: 'Poppins', sans-serif;
    text-shadow: 0 0 0.125em var(--clr-neon), 0 0 0.45em currentColor;
}

.sm {
    box-shadow: 0 0 0.1vw 0.3vw #fff7f7, 0 0 3vw 0.3vw #7528d6, inset 0 0 1vw 0.3vw #7528d6, inset 0 0 0.3vw 0.1vw #fff7f7;
}

.tee {
    text-shadow: 0 0 0.125em var(--clr-neon), 0 0 0.45em currentColor;
    color: #fff;
    font-family: 'Poppins', sans-serif;
    transform: translateY(32px);
    font-size: 20px;
}
  </style>

  <body>
  <div class="body">
        <div id="scoreBox">Score: 0</div>
        <div id="hiscoreBox">HiScore: 0</div>
        <div id="board"></div>
    </div>
    <div class="ad">
        <div class="te">

            <h1>Play Song</h1>
        </div>
        <div class="sm">
            <iframe src="https://open.spotify.com/embed/playlist/5OF5vSj3AgFeAKHwCKvDV3" width="100%" height="380" frameBorder="0" allowtransparency="true" allow="encrypted-media"></iframe>
        </div>
        <p class="tee">To start a game tap anywher on the <br> screen and press ↑ arrow </p>
    </div>
    <div class="button-container">
      <button><a href="login.php">Logout</a></button>
    </div>

    <script >
     
        // Game Constants & Variables
let inputDir = { x: 0, y: 0 };
const foodSound = new Audio('music/food.mp3');
const gameOverSound = new Audio('music/gameover.mp3');
const moveSound = new Audio('music/move.mp3');
const musicSound = new Audio('music/music');
let speed = 10;
let score = 0;
let level = 0;
let lastPaintTime = 0;
let snakeArr = [
    { x: 13, y: 15 }
];

food = { x: 6, y: 7 };
// Game Functions
function main(ctime) {
    window.requestAnimationFrame(main);
    // console.log(ctime)
    if ((ctime - lastPaintTime) / 1000 < 1 / speed) {
        return;
    }
    lastPaintTime = ctime;
    gameEngine();

}


function isCollide(snake) {
    // If you bump into yourself 
    for (let i = 1; i < snakeArr.length; i++) {
        if (snake[i].x === snake[0].x && snake[i].y === snake[0].y) {
            return true;
        }
    }
    // If you bump into the wall
    if (snake[0].x >= 18 || snake[0].x <= 0 || snake[0].y >= 18 || snake[0].y <= 0) {
        return true;
    }

    return false;
}

function gameEngine() {
    // Part 1: Updating the snake array & Food
    if (isCollide(snakeArr)) {
        gameOverSound.play();
        musicSound.pause();
        inputDir = { x: 0, y: 0 };
        alert("Game Over. Press any key to play again!");
        snakeArr = [{ x: 13, y: 15 }];
        musicSound.play();
        score = 0;
    }


    // If you have eaten the food, increment the score and regenerate the food
    if (snakeArr[0].y === food.y && snakeArr[0].x === food.x) {
        foodSound.play();
        score += 1;

        if (score > hiscoreval) {
            hiscoreval = score;
            localStorage.setItem("hiscore", JSON.stringify(hiscoreval));
            hiscoreBox.innerHTML = "HiScore: " + hiscoreval;
        }
        scoreBox.innerHTML = "Score: " + score;
        snakeArr.unshift({ x: snakeArr[0].x + inputDir.x, y: snakeArr[0].y + inputDir.y });
        let a = 2;
        let b = 16;
        food = { x: Math.round(a + (b - a) * Math.random()), y: Math.round(a + (b - a) * Math.random()) }
            //speed += 1
    }

    // Moving the snake
    for (let i = snakeArr.length - 2; i >= 0; i--) {
        snakeArr[i + 1] = {...snakeArr[i] };
    }

    snakeArr[0].x += inputDir.x;
    snakeArr[0].y += inputDir.y;

    // Part 2: Display the snake and Food
    // Display the snake
    board.innerHTML = "";
    snakeArr.forEach((e, index) => {
        snakeElement = document.createElement('div');
        snakeElement.style.gridRowStart = e.y;
        snakeElement.style.gridColumnStart = e.x;

        if (index === 0) {
            snakeElement.classList.add('head');
        } else {
            snakeElement.classList.add('snake');
        }
        board.appendChild(snakeElement);
    });
    // Display the food
    foodElement = document.createElement('div');
    foodElement.style.gridRowStart = food.y;
    foodElement.style.gridColumnStart = food.x;
    foodElement.classList.add('food')
    board.appendChild(foodElement);


}


// Main logic starts here
musicSound.play();
let hiscore = localStorage.getItem("hiscore");
if (hiscore === null) {
    hiscoreval = 0;
    localStorage.setItem("hiscore", JSON.stringify(hiscoreval))
} else {
    hiscoreval = JSON.parse(hiscore);
    hiscoreBox.innerHTML = "HiScore: " + hiscore;
}

window.requestAnimationFrame(main);
window.addEventListener('keydown', e => {
    inputDir = { x: 0, y: 1 } // Start the game
    moveSound.play();
    switch (e.key) {
        case "ArrowUp":
            console.log("ArrowUp");
            inputDir.x = 0;
            inputDir.y = -1;
            break;

        case "ArrowDown":
            console.log("ArrowDown");
            inputDir.x = 0;
            inputDir.y = 1;
            break;

        case "ArrowLeft":
            console.log("ArrowLeft");
            inputDir.x = -1;
            inputDir.y = 0;
            break;

        case "ArrowRight":
            console.log("ArrowRight");
            inputDir.x = 1;
            inputDir.y = 0;
            break;
        default:
            break;
    }

});
const panels = document.querySelectorAll('.panel');

  panels.forEach(panel => {
    panel.addEventListener('click', () => {
      removeActiveClasses();
      panel.classList.add('active');
    });
  });

  function removeActiveClasses() {
    panels.forEach(panel => {
      panel.classList.remove('active');
    });
  }

    </script>
  </body>
</html>