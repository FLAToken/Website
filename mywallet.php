<?php
require 'config.php';

session_start();

if (!$_SESSION['publicKey']) {
    header("Location: index.php");
    die();
}

require __DIR__ . '/vendor/autoload.php';

use EthereumRPC\EthereumRPC;
use ERC20\ERC20;

$geth = new EthereumRPC(GETH_URL, GETH_SSL, GETH_PORT);
$erc20 = new ERC20($geth);
$erc20->abiPath('flt.json');

$token = $erc20->token(FLT_ADDRESS);

$flt_cost = (1 / (float)$token->call('unitsOneEthCanBuy')[0]);
$flt_cost_format = number_format($flt_cost, 5, '.', '');
$url = 'https://api.coinmarketcap.com/v1/ticker/ethereum/?convert=USD';
$data = file_get_contents($url);
$priceInfo = json_decode($data)[0]->price_usd;

$mybalance = (float)$token->balanceOf($_SESSION['publicKey']);
$ethBalance = $geth->eth()->getBalance($_SESSION['publicKey']);
/*var_dump($token->balanceOf($_SESSION['publicKey']));
var_dump($geth->eth()->getBalance($_SESSION['publicKey']));*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>FLAToken | My Wallet</title>

    <?php include 'meta.php' ?>
</head>

<body class="mywallet">
    <section>
        <!--Navbar-->
        <nav class="navbar nav2 navbar-expand-lg navbar-dark fixed-top scrolling-navbar">
            <div class="container">
                <a class="navbar-brand" href="/"><img src="images/logo_mono.svg" alt="FLT"></a>
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-7" aria-controls="navbarSupportedContent-7" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar top-bar"></span>
                    <span class="icon-bar middle-bar"></span>
                    <span class="icon-bar bottom-bar"></span>
                    <span class="sr-only">Toggle navigation</span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent-7">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link aboutwhitepaper">Balance: <?php echo $ethBalance; ?> <b>ETH</b> ~ <?php echo number_format($ethBalance * $priceInfo, 2, '.', '') ?> <b>USD</b></a>
                        </li>
                    </ul>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent-7">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item mr-md-2 mb-md-0 mb-3">
                                <a class="nav-link btn btn-gradient-blue btn-glow wallet font-weight-bold" href="/topics.php">Topics</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-gradient-green btn-glow wallet font-weight-bold" href="#myModal" data-toggle="modal">Logout</a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

        </nav>
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <div class="modal-body text-center">
                        <div class="d-flex flex-column">
                            <p>Logout from your Account?</p>
                            <button class="btn btn-gradient-blue btn-glow my-2" id="logout">Logout</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Full Page Intro -->
    <div class="container pt-5">
        <div class="d-flex flex-column mt-5">
            <div class="card flex-grow-1 p-4 pull-up">

                <div class="title-wrap">
                    <h6 class="text-center balance-titolo balance-main">Your Balance</h6>
                </div>
                <p class="text-center balance"><?php echo $mybalance ?><span>FLT</span></p>
                <p class="text-center balance-usd">~ <?php echo number_format($mybalance * $flt_cost * $priceInfo, 2, '.', '') ?><span>USD</span></p>
                <div class="text-secondary text-center">
                    <?php echo $_SESSION['publicKey']; ?>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row mb-3">
                <div class="card col-md-5 mr-md-2 p-4 balance-titolo pull-up mt-3">
                    <h6>Buy Tokens</h6>
                    <div class="form-wrap">
                        <div class="input">
                            <label for="amount_eth">Amount in ETH</label>
                            <input type="text" name="amount_eth" id="amount_eth" autocomplete="off" data-validator="^\d*\.?\d*$">
                        </div>
                        <svg class="line">
                        </svg>
                    </div>
                    <div class="form-wrap mt-4">
                        <div class="input">
                            <label for="amount_flt">Amount in FLT</label>
                            <input type="text" name="amount_flt" id="amount_flt" autocomplete="off" data-validator="^\d*\.?\d*$">
                        </div>
                        <svg class="line">
                        </svg>
                    </div>
                    <p class="mt-2 text-center">1 FLT = <?php echo $flt_cost_format; ?> ETH ~ <?php echo number_format($flt_cost_format * $priceInfo, 3, '.', ''); ?> USD</p>
                    <p class="mt-2 text-center"><i class="fas fa-info-circle"></i> Each 1 ETH spent +100 FLT bonus!</p>
                    <button class="btn btn-gradient-blue btn-glow my-2 mt-3 btn-important" id="buy">Buy <i class="fas fa-shopping-cart"></i></button>
                </div>
                <div class="card flex-grow-1 ml-md-2 p-4 balance-titolo pull-up mt-3">
                    <h6>Send Tokens</h6>
                    <div class="form-wrap">
                        <div class="input">
                            <label for="address">Destination address</label>
                            <input type="text" name="address_send" id="address_send" autocomplete="off" data-validator="^0x[a-fA-F0-9]{40}$">
                        </div>
                        <svg class="line">
                        </svg>
                    </div>
                    <div class="form-wrap mt-4">
                        <div class="input">
                            <label for="amount">Amount in FLT</label>
                            <input type="text" name="amount_send" id="amount_send" autocomplete="off" data-validator="^\d*\.?\d*$">
                        </div>
                        <svg class="line">
                        </svg>
                    </div>
                    <p class="mt-2 text-center">Send your FLTs to another address!</p>
                    <p class="mt-2 text-center">&nbsp;</p>
                    <button class="btn btn-gradient-blue btn-glow my-2 mt-3 btn-important" id="send">Send <i class="fas fa-arrow-circle-right"></i></button>
                </div>
            </div>
        </div>
    </div>


    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/snap.svg/0.4.1/snap.svg-min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="https://cdn.rawgit.com/mgalante/jquery.redirect/master/jquery.redirect.js"></script>

    <script>
        $(function() {
            $(window).scroll(function() {
                if ($(this).scrollTop() > 200) {
                    $('.fab-container').css({
                        'bottom': '0px',
                        'transition': '.3s'
                    });
                } else {
                    $('.fab-container').css({
                        'bottom': '-80px'
                    });
                }
            });

            $('div[href="#top"]').on("click", function() {
                return $("html, body").animate({
                    scrollTop: 0
                }, "slow"), !1
            });

            $("#amount_eth").on('change keyup paste', function() {
                var flt = Number($('#amount_eth').val()) / <?php echo $flt_cost; ?>;
                $("#amount_flt").val(flt);
                animateInput(amount_flt);
            });
            $("#amount_flt").on('change keyup paste', function() {
                var flt = Number($('#amount_flt').val()) * <?php echo $flt_cost; ?>;
                $("#amount_eth").val(Number(flt.toFixed(11)));
                animateInput(amount_eth);
            });
        });
    </script>

    <script src="js/index.js"></script>

    <script>
        var tokenAddress = '<?php echo FLT_ADDRESS ?>';
        var fltABI = <?php echo FLT_ABI ?>;

        $(document).ready(function() {
            $('#logout').click(function(e) {
                e.preventDefault();
                $.redirect('logout.php');
            });

            $('#buy').click(function(e) {
                e.preventDefault();
                buy($(this));
            });

            $('#send').click(function(e) {
                e.preventDefault();
                send($(this));
            });
        });

        var ethBrowser = false;
        window.addEventListener('load', async () => {
            if (window.ethereum) {
                window.web3 = new Web3(ethereum);
                try {
                    await ethereum.enable();
                    ethBrowser = true;
                } catch (error) {
                    alert('we need access to your wallet!');
                }
            } else if (window.web3) {
                window.web3 = new Web3(web3.currentProvider);
                ethBrowser = true;
            } else {
                alert('Non-Ethereum browser detected. You should consider trying MetaMask!');
            }

            console.log(web3.version.api);
        });

        function buy(button) {
            if (!ethBrowser) {
                alert('Non-Ethereum browser detected. You should consider trying MetaMask!');
                return;
            }

            button.attr('disabled', true);
            button.html('Pending...');

            var amount = web3.toWei($('#amount_eth').val(), 'ether');

            let contract = web3.eth.contract(fltABI).at(tokenAddress);
            contract.buy({
                from: '<?php echo $_SESSION['publicKey']; ?>',
                value: amount
            }, function(err, res) {
                if (err) {
                    button.removeAttr('disabled');
                    button.html('Buy <i class="fas fa-shopping-cart"></i>');
                    return;
                }
                confirmEtherTransaction(res);
            });
        }

        function send(button) {
            if (!ethBrowser) {
                alert('Non-Ethereum browser detected. You should consider trying MetaMask!');
                return;
            }

            button.attr('disabled', true);
            button.html('Pending...');
            var amount = web3.toWei($('#amount_send').val(), 'ether');
            let toAddress = $('#address_send').val();

            let contract = web3.eth.contract(fltABI).at(tokenAddress);
            contract.transfer(toAddress, amount, (error, txHash) => {
                if (error) {
                    button.removeAttr('disabled');
                    button.html('Send <i class="fas fa-arrow-circle-right"></i>');
                    return;
                }
                console.log(txHash);
                confirmEtherTransaction(txHash);
            });
        }

        function confirmEtherTransaction(txHash, confirmations = 1) {
            setTimeout(() => {
                getConfirmations(txHash, function(trxConfirmations) {
                    if (trxConfirmations >= confirmations) {
                        location.reload(true);
                        return
                    }
                    return confirmEtherTransaction(txHash, confirmations)
                })
            }, 1000)
        }

        function getConfirmations(txHash, cb) {
            try {
                web3.eth.getTransaction(txHash, function(err, trx) {
                    if(err) {
                        cb(0);
                        return;
                    }
                    web3.eth.getBlockNumber(function(err, currentBlock) {
                        cb(trx.blockNumber === null ? 0 : currentBlock - trx.blockNumber);
                    });
                });
            } catch (error) {
                console.log(error)
            }
        }
    </script>
</body>

</html>