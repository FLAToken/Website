<?php
require 'config.php';

session_start();

if (!empty($_POST)) {
    if (isset($_POST['publicKey'])) {
        $_SESSION['publicKey'] = $_POST['publicKey'];
        header("Location: mywallet.php");
        die();
    }
}

if (isset($_SESSION['publicKey'])) {
    header("Location: mywallet.php");
    die();
}

require __DIR__ . '/vendor/autoload.php';

use EthereumRPC\EthereumRPC;
use ERC20\ERC20;

$geth = new EthereumRPC(GETH_URL, GETH_SSL, GETH_PORT);
$erc20 = new ERC20($geth);
$erc20->abiPath('flt.json');

$token = $erc20->token(FLT_ADDRESS);
/*
var_dump($token->name());
var_dump($token->decimals());
var_dump($token->symbol());
var_dump($token->totalSupply());
var_dump($token->call('getTopicsCount'));*/
$total = $token->totalSupply();
$tokenSold = (int)$token->tokenSold();
$sold = number_format($tokenSold, 0);
$percentageSold = number_format((float)($tokenSold * 100 / $total), 2, '.', '');
?>
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <title>FLAToken | The Real Cryptocurrency</title>

    <?php include 'meta.php' ?>

    <link rel="stylesheet" type="text/css" href="token.css">
    <link rel="stylesheet" type="text/css" href="flipclock.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
</head>

<body>

    <!-- START LOADER -->
    <div id="loader-wrapper">
        <div id="loading-center-absolute">
            <div class="object" id="object_four"></div>
            <div class="object" id="object_three"></div>
            <div class="object" id="object_two"></div>
            <div class="object" id="object_one"></div>
        </div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>

    </div>
    <!-- END LOADER -->

    <header>
        <!--Navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top scrolling-navbar">
            <div class="container">
                <a class="navbar-brand" href="#top"><img src="images/logo_mono.svg" alt="FLT"></a>
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-7" aria-controls="navbarSupportedContent-7" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar top-bar"></span>
                    <span class="icon-bar middle-bar"></span>
                    <span class="icon-bar bottom-bar"></span>
                    <span class="sr-only">Toggle navigation</span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent-7">
                    <ul class="navbar-nav mr-auto nav-left">
                        <li class="nav-item">
                            <a class="nav-link aboutwhitepaper" href="#whitepaper">WhitePaper</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link aboutwhitepaper" href="#ico">ICO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link aboutwhitepaper" href="#about">About</a>
                        </li>
                    </ul>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent-7">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item mr-lg-2 mb-lg-0 mb-3 mr-0">
                                <a class="nav-link btn btn-gradient-blue btn-glow wallet font-weight-bold" href="/topics.php">Topics</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-gradient-green btn-glow wallet font-weight-bold" href="#myModal" data-toggle="modal">MyWallet</a>
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
                            <p>Login to your FLAToken account</p>
                            <button class="btn btn-gradient-blue btn-glow my-2" id="login">Login</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Navbar -->
        <!-- Full Page Intro -->
        <div class="view header" id="top">
            <!-- Mask & flexbox options-->
            <div class="mask rgba-black-light align-items-center h-100">
                <!-- Content -->
                <div class="container h-100">
                    <!--Grid row-->
                    <div class="d-flex flex-column h-85">
                        <!--Grid column-->
                        <div class="col-md-12 mb-4 white-text text-center">
                            <h1 class="h1-reponsive white-text text-uppercase font-weight-bold mb-0 pt-md-5 pt-5 mt-md-0 mt-4 wow fadeInDown text-title" data-wow-delay="0.3s"><strong>FLAToken</strong></h1>
                            <hr class="hr-light my-4 wow fadeInDown" data-wow-delay="0.4s">
                            <h5 class="text-uppercase mb-4 white-text wow fadeInDown" data-wow-delay="0.4s">
                                <strong>The real cryptocurrency</strong></h5>
                            <a class="btn btn-outline-white wow fadeInDown acquistavendi" href="#howtobuy" data-wow-delay="0.4s">How to Buy?</a>
                        </div>
                        <div class="mx-auto mt-auto">
                            <div href="#whitepaper">
                                <span class="scrolldown d-flex flex-column">
                                    <span>Scroll down</span>
                                    <i class="fas fa-sort-down mx-auto"></i>
                                </span>
                            </div>
                        </div>
                        <!--Grid column-->
                    </div>
                    <!--Grid row-->
                </div>
                <!-- Content -->
            </div>
            <!-- Mask & flexbox options-->
        </div>
        <!-- Full Page Intro -->
    </header>
    <!-- Main navigation -->
    <!--Main Layout-->

    <section class="bg-chiaro" id="whitepaper">
        <div class="container pt-4">
            <!--Grid row-->
            <div class="row py-5">
                <!--Grid column-->
                <div class="col-md-12 row mx-auto">
                    <div class="col-12 col-md-6 d-flex flex-column">
                        <h3 class="text-center">WhitePaper</h3>
                        <div class="mt-5 text-center text-md-left">
                            <p class="text-justify">In a society where people and their opinions mean everything, we have made <b>FLAToken</b>.</p>
                            <p class="text-justify">It’s not just a simple crowdfunding ERC20 token. FLAT itself is a decentralized opinion platform, where users can share thoughts and ideas with others.</p>
                            <p class="text-justify">In a decentralized context, every single thought shared has its own value, small or large it doesn’t matter, but it’s worth! The more people interact with your post, the more your thought will have value.</p>
                            <p class="text-justify">Read our <b>WhitePaper</b> to learn more.</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mt-md-0 mt-3">
                        <img src="images/book.png" alt="" class="whitepaper-img mx-auto row">
                        <div class="row">
                            <button class="btn btn-gradient-blue btn-glow my-2 mt-5 mx-auto btn-important download-wp">Download <i class="fas fa-download"></i></button>
                        </div>
                    </div>

                </div>
                <!--Grid column-->
            </div>
            <!--Grid row-->
        </div>
    </section>

    <section class="bg-scuro" id="howtobuy">
        <div class="container pt-4">
            <!--Grid row-->
            <div class="row py-5">
                <!--Grid column-->
                <div class="col-md-12 mt-1">
                    <h3 class="text-center">How to Buy?</h3>
                    <p class="text-center px-md-5">We've tried to simplify token purchase as simple as possible, for this reason at moment website fully works on Desktop/Computer, mobile version cannot run all features because lack of some Ethereum browser extensions. On the understanding that you can always buy your FLTs through the official Smart Contract, we advise the following steps.</p>
                    <hr class="hr-light my-4 wow fadeInDown" data-wow-delay="0.4s">
                    <div class="d-flex flex-row flex-wrap">
                        <div class="col d-flex">
                            <p class="my-auto text-justify"><b>Setp 1:</b> Since FLAT is an ERC20 Token on the Etheruem Blockchain (<a href="https://en.wikipedia.org/wiki/ERC-20" target="_blank">Info</a>), to interact with FLAT d-app you'll need an Etherum browser. So, the first step is to install an extension, we advise <a href="https://metamask.io/" target="_blank">MetaMask</a>. Follow the very intuitive steps to get your Ethereum Wallet.</p>
                        </div>
                        <div class="col text-center">
                            <img src="images/step_1.jpg" alt="Step 1" class="landing-img">
                        </div>
                    </div>
                    <div class="d-flex flex-row-reverse flex-wrap">
                        <div class="col d-flex">
                            <p class="my-auto text-justify"><b>Step 2:</b> Because FLTs can be bought only in Ethereum you need to buy some coins first and then transfer to your new MetaMask wallet. You can choose whatever you want to do this step, MetaMask offer its own Deposit method or you can use another <u>well-known and <b>reliable</b> Exchanges</u> (i.e. <a href="https://www.coinbase.com" target="_blank">Coinbase</a> or <a href="https://www.binance.com" target="_blank">Binance</a>) then transfer coins to MetaMask wallet.</p>
                        </div>
                        <div class="col text-center">
                            <img src="images/step_2.jpg" alt="Step 2" class="landing-img">
                        </div>
                    </div>
                    <div class="d-flex flex-row flex-wrap mt-3">
                        <div class="col d-flex">
                            <p class="my-auto text-justify"><b>Step 3:</b> Once you have your ETHs in your MetaMask wallet you can access to FLAToken MyWallet Dashboard by clicking on MyWallet button.</p>
                        </div>
                        <div class="col text-center">
                            <img src="images/step_3.jpg" alt="Step 3" class="landing-img land">
                        </div>
                    </div>
                    <div class="d-flex flex-row-reverse flex-wrap">
                        <div class="col d-flex">
                            <p class="my-auto text-justify"><b>Step 4:</b> Here we are! You can finally buy FLAToken! Choose how many ETH you would convert and click Buy button. Be aware, do not convert all your ETH in FLT, keep 3/4$ in your wallet to pay Ethereum GAS transactions!</p>
                        </div>
                        <div class="col text-center">
                            <img src="images/step_4.jpg" alt="Step 4" class="landing-img">
                        </div>
                    </div>
                    <div class="d-flex flex-row flex-wrap mt-3">
                        <div class="col d-flex">
                            <p class="my-auto text-justify"><b>Step 5:</b> Go to Topics sections on this site and start using your brand new FLATokens ❤️</p>
                        </div>
                        <div class="col text-center">
                            <img src="images/step_5.jpg" alt="Step 5" class="landing-img land">
                        </div>
                    </div>
                </div>
                <!--Grid column-->
            </div>
            <!--Grid row-->
        </div>
    </section>

    <section class="bg-chiaro" id="ico">
        <div class="container d-flex py-4 flex-column">
            <div class="col-md-12 text-center mt-5">
                <h3>Initial Coin Offering</h3>
                <p>Our ICO is composed by 5 milestones: <b>Starter Cap</b>, <b>Soft Cap</b>, <b>Half Revolution</b>, <b>Hard Cap</b> and <b>Bonus</b>.</p>
                <p><b>Starter Cap</b> With this goal we will keep the community online and always updated, we are not so much, but enough to keep FLAT alive.</p>
                <p><b>Soft Cap</b> This is the minimum to start developing something serious, we have a solid community and new features will arrive on the platform, with a more interaction between users.</p>
                <p><b>Half Revolution</b> Half tokens sold, yes, we are small compared to other social media, but this is already a revolution! Text will not be the unique form of expression; many other amazing features will be developed to help people express their own opinions.</p>
                <p><b>Hard Cap</b> This is our Hard Cap. It’s the most important goal to reach, not just for features and project improvements, but for the essence of the project itself.</p>
                <p><b>Bonus</b> It’s a bonus step, anything here could be an amazing surprise! 😲</p>
            </div>
            <div class="token-sale-counter w-100 my-5">
                <div class="token-details text-center">
                    <!-- ICO Counter -->
                    <div class="clock-counter mb-4">
                        <div class="message">ICO has started!</div>
                        <div class="clock ml-0 mt-5 d-flex justify-content-center"></div>
                    </div>
                    <!-- ICO Counter -->
                    <!-- Progressbar -->
                    <div class="loading-bar mb-2 position-relative">
                        <div class="progres-area pb-5 pt-4">
                            <ul class="progress-top">
                                <li></li>
                                <li class="pre-sale">Starter Cap</li>
                                <li class="soft-cap">Soft Cap</li>
                                <li class="medium-cap">Half Revolution</li>
                                <li class="hard-cap">Hard Cap</li>
                                <li class="bonus">Bonus</li>
                                <li></li>
                            </ul>
                            <ul class="progress-bars">
                                <li></li>
                                <li>|</li>
                                <li>|</li>
                                <li>|</li>
                                <li>|</li>
                                <li>|</li>
                                <li></li>
                            </ul>
                            <div class="progress">
                                <div class="progress-bar progress-bar-custom" role="progressbar" style="width: <?php echo (float)$percentageSold ?>%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="progress-bottom">
                                <div class="progress-info"><?php echo (float)$percentageSold ?>% sold</div>


                                <div class="progress-info"><?php echo $sold ?> FLT Sold!</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <div class="fab-container">
        <div class="top n-fab d-flex" tooltip="Back To Top" href="#top"><i class="fas fa-chevron-up mx-auto my-auto"></i></div>
    </div>

    <!--Main Layout-->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="https://cdn.rawgit.com/mgalante/jquery.redirect/master/jquery.redirect.js"></script>
    <script src="js/flipclock.min.js"></script>

    <script>
        $(function() {
            $(document).scroll(function() {
                var $nav = $(".navbar.fixed-top");
                $nav.toggleClass('scrolled', $(this).scrollTop() > $nav.height());
            });
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
        });
        $(document).on('click', 'a[href^="#"], div[href^="#"]', function(event) {
            event.preventDefault();

            $('html, body').animate({
                scrollTop: $($.attr(this, 'href')).offset().top
            }, 500);
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.download-wp').click((e) => {
                e.preventDefault();
                window.open('/whitepaper_export.pdf', '_blank');
            });

            $('#login').click(async (e) => {
                e.preventDefault();
                if (window.ethereum) {
                    window.web3 = new Web3(ethereum);
                    try {
                        await ethereum.enable();
                        $.redirect('index.php', {
                            'publicKey': web3.eth.accounts[0]
                        });
                    } catch (error) {
                        alert('we need access to your wallet!');
                    }
                } else if (window.web3) {
                    window.web3 = new Web3(web3.currentProvider);
                    ethBrowser = true;
                } else {
                    alert('Non-Ethereum browser detected. You should consider trying MetaMask!');
                }
            });

            var clock;
            var date = new Date(2019, 5, 30, 23, 23, 23, 23);
            var now = new Date();
            var diff = (date.getTime() / 1000) - (now.getTime() / 1000);

            clock = $('.clock').FlipClock(diff, {
                clockFace: 'DailyCounter',
                autoStart: false,
                callbacks: {
                    stop: function() {
                        $('.message').html('ICO has closed, Thank you!')
                    }
                }
            });
            clock.setCountdown(true);
            clock.start();

        });

        var ethBrowser = false;
    </script>

    <script>
        var timer = 0;
        var percentageWidth;
        $(document).ready(function() {
            console.log('run');
            percentageWidth = $('#progressBar').outerWidth() / 100;
            console.log(percentageWidth);
            timerRun();
        });

        function timerRun() {

            $('#progressBar .progress-bar').css("width", timer + "%").attr("aria-valuenow", timer);

            $('#progressBar .progress-number').css("-webkit-transform", "translateX(" + percentageWidth * timer + "px)").attr("aria-valuenow", timer);

            if (timer >= 70) {
                $('#progressBar .progress-bar').css("width", "70%");
                return;
            }
            timer++;
            setTimeout(function() {
                timerRun()
            }, 50);
        }
    </script>

    <script>
        $(window).on("load", function() {
            var preLoder = $(".loader-wrapper");
            preLoder.delay(700).fadeOut(500);
            $("body").addClass("loaded");
        });
    </script>
</body>

</html>
