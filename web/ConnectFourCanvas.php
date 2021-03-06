<html>

	<head>

		<meta name="viewport" content="width=device-width; initial-scale=3.0; maximum-scale=3.0; user-scalable=0;" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />

	</head>

	<body onload="newGame();" style="font-family: sans-serif;">
		<div style="width: 280px; margin-left: auto; margin-right: auto; background: gray; border-radius: 15px; padding: 25px; padding-top: 10px; height:400px;">
			<div id="div_title" onclick="if (gameOver) {newGame();}">
				Connect 4!
			</div>
			<canvas id="connect_four" width="280" height="240"></canvas>
			<div id="outer">
				<div id="turn" style="float: left;">
					<span style="color: red;">Red turn</span>
				</div>
				<button style="float: right;" id="random" onClick="placePiece(turn, chooseRandomMove(Board), Board);">
					Random Move
				</button>
			</div>
			<div id="scoreboard" style="margin-top: 50px;">
				<div id="red_score" style="float: left; background: #660000;"></div>
				<div id="green_score" style="float: right; background: #006600;"></div>
			</div>
		</div>
		<script type="text/javascript">
			var canvas;
			var ctx;
			var rows;
			var cols;
			var width;
			var Board;
			var turn;
			var gameOver;
			var greenScore = 0;
			var redScore = 0;
			canvas = document.getElementById("connect_four");
			ctx = canvas.getContext("2d");
			function newGame() {

				ctx.fillStyle = "#CCCCCC";
				ctx.fillRect(0, 0, 280, 240);

				startLeft = 0;
				width = 40;
				for ( row = 0; row < 10; row = row + 1) {
					for ( col = startLeft; col < 10; col = col + 1) {
						ctx.fillRect((row - 1) * width, (col - 1) * width, (row + 0) * width, (col + 0) * width);
						ctx.beginPath();
						ctx.arc((row - 0.5) * width, (col - 0.5) * width, width / 2 - 2, 0, 2 * Math.PI, 0);
						ctx.fillStyle = "#EEEEEE";
						ctx.fill();

						if ((col + startLeft) % 2 == 0) {
							ctx.fillStyle = "#000000";
						} else {
							ctx.fillStyle = "#000000";
						}
					}
					if (startLeft == 1) {
						startLeft = 0;
					} else {
						startLeft = 1;
					}
				}
				rows = 6;
				cols = 7;
				// Create the array
				// Board can be indexed matrix style as Board[x][y]
				Board = new Array(cols);
				for ( i = 0; i < Board.length; ++i) {
					Board[i] = new Array(rows);
					for ( j = 0; j < Board[i].length; ++j) {
						Board[i][j] = 0;
					}
				}
				turn = "red";
				document.getElementById("turn").innerHTML = "<span style='color: red;'>Red Turn</span>";
				gameOver = false;
				document.getElementById("div_title").innerHTML = "Connect 4!";
				updateScores();
			}

			// This will contain the rules and board model.

			turn = "red"
			function swapTurn() {
				if (turn == "red") {
					turn = "green";
					document.getElementById("turn").innerHTML = "<span style='color: green;'>Green Turn</span>";
				} else {
					turn = "red";
					document.getElementById("turn").innerHTML = "<span style='color: red;'>Red Turn</span>";
				}
			}

			function colorBoard(color, column, row) {
				ctx.beginPath();
				if (color == "red") {
					ctx.fillStyle = "660000";
				}
				if (color == "green") {
					ctx.fillStyle = "#006600";
				}
				ctx.arc((column + 0.5) * width, (row + 0.5) * width, width / 2 - 2, 0, 2 * Math.PI, 0);
				ctx.fill();
			}

			// Check win condition. The win occurs when 4 pieces in a row are the same color.
			// To make this easier, first there's a getNeighborIndices method.
			function getNeighborIndices(column, row) {
				i = 0;
				output = new Array(1);
				for ( left = column - 1; left < column + 2; ++left) {
					for ( topp = row - 1; topp < row + 2; ++topp) {
						if (left >= 0 && left < cols && topp >= 0 && topp < rows && !(left == column && topp == row)) {
							output[i] = [left, topp]; ++i;
						}
					}
				}
				return output;
			}

			function checkWin(column, row, board) {
				currentColor = board[column][row];
				if (currentColor == 0) {
					return false;
				}
				// check the horizontal wins
				try {
					if (board[column-3][row] == currentColor && board[column-2][row] == currentColor && board[column-1][row] == currentColor && board[column-0][row] == currentColor) {
						return true;
					}
				} catch (err) {
				}
				try {
					if (board[column+1][row] == currentColor && board[column-2][row] == currentColor && board[column-1][row] == currentColor && board[column-0][row] == currentColor) {
						return true;
					}
				} catch (err) {
				}
				try {
					if (board[column+2][row] == currentColor && board[column+1][row] == currentColor && board[column-1][row] == currentColor && board[column-0][row] == currentColor) {
						return true;
					}
				} catch (err) {
				}
				try {
					if (board[column+1][row] == currentColor && board[column+2][row] == currentColor && board[column+3][row] == currentColor && board[column-0][row] == currentColor) {
						return true;
					}
				} catch (err) {
				}
				// check the vertical wins
				try {
					if (board[column][row - 3] == currentColor && board[column][row - 2] == currentColor && board[column][row - 1] == currentColor && board[column][row - 0] == currentColor) {
						return true;
					}
				} catch (err) {
				}
				try {
					if (board[column][row + 1] == currentColor && board[column][row - 2] == currentColor && board[column][row - 1] == currentColor && board[column][row - 0] == currentColor) {
						return true;
					}
				} catch (err) {
				}
				try {
					if (board[column][row + 1] == currentColor && board[column][row + 2] == currentColor && board[column][row - 1] == currentColor && board[column][row - 0] == currentColor) {
						return true;
					}
				} catch (err) {
				}
				try {
					if (board[column][row + 1] == currentColor && board[column][row + 2] == currentColor && board[column][row + 3] == currentColor && board[column][row - 0] == currentColor) {
						return true;
					}
				} catch (err) {
				}
				// check the up-left wins
				try {
					if (board[column-3][row - 3] == currentColor && board[column-2][row - 2] == currentColor && board[column-1][row - 1] == currentColor && board[column-0][row - 0] == currentColor) {
						return true;
					}
				} catch (err) {
				}
				try {
					if (board[column+1][row + 1] == currentColor && board[column-2][row - 2] == currentColor && board[column-1][row - 1] == currentColor && board[column-0][row - 0] == currentColor) {
						return true;
					}
				} catch (err) {
				}
				try {
					if (board[column+1][row + 1] == currentColor && board[column+2][row + 2] == currentColor && board[column-1][row - 1] == currentColor && board[column-0][row - 0] == currentColor) {
						return true;
					}
				} catch (err) {
				}
				try {
					if (board[column+1][row + 1] == currentColor && board[column+2][row + 2] == currentColor && board[column+3][row + 3] == currentColor && board[column-0][row - 0] == currentColor) {
						return true;
					}
				} catch (err) {
				}
				// check the up-right wins
				try {
					if (board[column+3][row - 3] == currentColor && board[column+2][row - 2] == currentColor && board[column+1][row - 1] == currentColor && board[column+0][row - 0] == currentColor) {
						return true;
					}
				} catch (err) {
				}
				try {
					if (board[column-1][row + 1] == currentColor && board[column+2][row - 2] == currentColor && board[column+1][row - 1] == currentColor && board[column-0][row - 0] == currentColor) {
						return true;
					}
				} catch (err) {
				}
				try {
					if (board[column-1][row + 1] == currentColor && board[column-2][row + 2] == currentColor && board[column+1][row - 1] == currentColor && board[column-0][row - 0] == currentColor) {
						return true;
					}
				} catch (err) {
				}
				try {
					if (board[column-1][row + 1] == currentColor && board[column-2][row + 2] == currentColor && board[column-3][row + 3] == currentColor && board[column-0][row - 0] == currentColor) {
						return true;
					}
				} catch (err) {
				}
				return false;
			}

			// Place piece function consumes a column number (0 indexed) and places the piece.
			// Returns row if the placement was legal, else returns -1.
			function placePiece(color, column, board) {
				if (gameOver) {
					return;
				}
				// Boundary conditions
				if (column < 0 || column >= cols) {
					return -1;
				}
				// Too many pieces placed...
				if (board[column][0] != 0) {
					return -1;
				}
				// Now propagate the piece to the bottom.
				r = 0;
				while (r < rows && board[column][r] == 0) {
					r++;
				}
				r--;
				board[column][r] = color;
				colorBoard(color, column, r);
				if (checkWin(column, r, board) == true) {
					document.getElementById("div_title").innerHTML = color + " wins!! click here to play again";
					gameOver = true;
					incrementScore(color);
				}
				swapTurn();
				return r;
			}

			function placeOnClick(e) {
				var x;
				var y;
				if (e.pageX || e.pageY) {
					x = e.pageX;
					y = e.pageY;
				} else {
					x = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
					y = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
				}
				x -= canvas.offsetLeft;
				y -= canvas.offsetTop;

				column = Math.floor(x / width);
				row = Math.floor(y / width);
				placePiece(turn, column, Board);
			}


			canvas.addEventListener("click", placeOnClick, false);

			function getMoves(board) {
				moves = new Array(1);
				j = 0;
				for ( i = 0; i < board.length; ++i) {
					if (board[i][0] == 0) {
						moves[j] = i;
						++j
					}
				}
				return moves;
			}

			function chooseRandomMove(board) {
				moves = getMoves(board);
				return moves[Math.floor(Math.random() * moves.length)];
			}

			function incrementScore(color) {
				if (color == "green") {
					greenScore = greenScore + 1;
				} else {
					redScore = redScore + 1;
				}
			}

			function updateScores() {
				document.getElementById("green_score").innerHTML = "<p>Green Team Score:</p><p>" + greenScore.toString() + "</p>";
				document.getElementById("red_score").innerHTML = "<p>Red Team Score:</p><p>" + redScore.toString() + "</p>";
			}
		</script>

	</body>

</html>
