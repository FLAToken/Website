<?php
require 'config.php';

session_start();

require __DIR__ . '/vendor/autoload.php';

use EthereumRPC\EthereumRPC;
use ERC20\ERC20;

$geth = new EthereumRPC(GETH_URL, GETH_SSL, GETH_PORT);
$erc20 = new ERC20($geth);
$erc20->abiPath('flt.json');

$token = $erc20->token(FLT_ADDRESS);

$publicKey = '';
if (isset($_SESSION['publicKey'])) {
    $publicKey = $_SESSION['publicKey'];
    /*var_dump($token->balanceOf($_SESSION['publicKey']));
    var_dump($geth->eth()->getBalance($_SESSION['publicKey']));*/
}
if (isset($_GET['p'])) {
    $page = $_GET['p'];
} else {
    $page = 0;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>FLAToken | Topics</title>

    <?php include 'meta.php' ?>

    <script type="text/javascript" src="js/sanitize-html.min.js"></script>
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
                    <?php if (isset($_SESSION['publicKey'])) { ?>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link aboutwhitepaper" href="mywallet.php" id="my-wallet">My Wallet <?php echo (float)$token->balanceOf($_SESSION['publicKey']); ?> FLT - <?php echo $geth->eth()->getBalance($_SESSION['publicKey']); ?> ETH</a>
                            </li>
                        </ul>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent-7">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link btn btn-gradient-green btn-glow wallet font-weight-bold" href="#myModal" data-toggle="modal">Logout</a>
                                </li>
                            </ul>
                        </div>
                    <?php } else { ?>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link btn btn-gradient-blue btn-glow wallet font-weight-bold" href="/">Login</a>
                            </li>
                        </ul>
                    <?php } ?>
                </div>
            </div>

        </nav>
        <!-- Modal Logout -->
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
        <!-- Modal Welcome -->
        <div class="modal fade" id="modalWelcome" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Welcome to Topics!</h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="d-flex flex-column">
                            <p>In this section you can express your opinion protected by <b>security</b> and <b>anonymity</b> of the Blockchain 👻</p>
                            <button type="button" class="btn btn-gradient-blue btn-glow" data-dismiss="modal">Okay, I understand</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Full Page topics -->
    <div class="container pt-5">
        <?php if (isset($_SESSION['publicKey'])) { ?>
            <div class="d-flex flex-row mt-5">
                <div class="card flex-column flex-grow-1 p-4 statement-card">
                    <h6 class="text-center text-md-left">Enter your question or statement here:</h6>
                    <div class="d-flex flex-md-row flex-column">
                        <textarea class="form-control mr-md-3 mb-md-0 mb-3" rows="2" name="newTopic" id="newTopicArea" placeholder="I believe in... unicorns!"></textarea>
                        <i class="fas fa-info-circle mt-auto pr-3" data-toggle="tooltip" data-placement="bottom" title="Send a topic costs 1 FLT"></i>
                        <div class="d-flex">
                            <button id="newTopic" class="btn btn-gradient-blue btn-glow btn-important mt-auto mx-auto d-flex flex-nowrap"><span>Share&nbsp;</span><i class="fas fa-comment mt-1"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="topics-container d-flex-flex-column" id="topics">

        </div>

        <div class="mt-4">
            <nav aria-label="Page navigation exemple" class="d-flex">
                <ul class="pagination mx-auto">
                </ul>
            </nav>
        </div>
    </div>

    <div class="fab-container">
        <div class="top n-fab d-flex" tooltip="Back To Top" href="#top"><i class="fas fa-chevron-up mx-auto my-auto"></i>
        </div>
    </div>



    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/snap.svg/0.4.1/snap.svg-min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="https://cdn.rawgit.com/mgalante/jquery.redirect/master/jquery.redirect.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js@1.0.0-beta.36/dist/web3.min.js"></script>

    <script>
        $(function() {
            <?php if (!isset($_SESSION['publicKey'])) { ?>
                $('#modalWelcome').modal('show');
            <?php } ?>
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
    </script>

    <script src="js/index.js"></script>

    <script>
        var tokenAddress = '<?php echo FLT_ADDRESS ?>';
        var fltABI = <?php echo FLT_ABI ?>;
        var contract, contractJS;
        var topics = [];
        var pages = 1;
        var max_topic_per_page = 25;
        var charPostLimit = 500;

        var ethBrowser = false;
        window.addEventListener('load', async () => {
            var me = '<?php echo $publicKey; ?>';
            if (window.ethereum && me !== '') {
                console.log('eth browser');
                window.web3js = window.web3;
                window.web3 = new Web3(ethereum);
                try {
                    await ethereum.enable();
                    ethBrowser = true;
                } catch (error) {
                    alert('To interact with Smart Contract you have to enable MetaMask!');
                }
            } else if (window.web3) {
                window.web3js = window.web3;
                window.web3 = new Web3(web3.currentProvider);
                ethBrowser = true;
            } else {
                ethBrowser = false;
                window.web3 = new Web3(new Web3.providers.HttpProvider('<?php echo GETH_URL_JS; ?>'));
            }

            window.web3Ws = new Web3(new Web3.providers.WebsocketProvider('<?php echo GETH_URL_WS_JS; ?>'));
            contract = new web3Ws.eth.Contract(fltABI, tokenAddress);
            if (typeof web3js !== 'undefined')
                contractJS = web3js.eth.contract(fltABI).at(tokenAddress);

            getTopicsList();
            listenContractEvents();
        });

        $(document).ready(function() {
            $('#logout').click(function(e) {
                e.preventDefault();
                $.redirect('logout.php');
            });
            $('#newTopic').click(function(e) {
                e.preventDefault();
                $(this).attr('disabled', '');
                $('#newTopicArea').attr('disabled', '');
                createNewTopic();
            });
        });

        function generateTopicHTML(key, topic) {
            topic.argument = topic.argument || topic.arg;
            var argument = sanitizeHtml(topic.argument,{
  allowedTags: sanitizeHtml.defaults.allowedTags.concat([ '3' ])
}).substring(0, charPostLimit);
            var me = '<?php echo $publicKey; ?>';
            var html = '<div class="d-flex flex-row mt-4" id="' + key + '"><div class="card card-topic flex-column flex-grow-1 p-4 ' + (topic.sender.toLowerCase() === me ? 'statement-card' : 'pull-up') + '">';
            html += '<p class="text-secondary text-break font-weight-bold d-flex justify-content-between flex-wrap"><span>' + topic.sender + '</span><a href="javascript:void(0)" onclick="copyToClipboard(\'https://flatoken.net/topic.php?t=' + key + '\', this);" data-toggle="tooltip" data-placement="bottom" title="Copy to clipboard" class="ml-auto"><i class="fas fa-share-alt"></a></i></p>'
            html += '<div class="d-flex flex-md-row flex-column">';
            html += '<p class="col argument">' + argument + '</p>';
            html += '<div class="d-flex flex-column my-auto">';
            var logged = topic.sender.toLowerCase() !== me && me !== '';
            if (logged) {
                html += '<div class="form-wrap ml-auto"><div class="input"><label for="amount_flt">Amount in FLT</label>';
                html += '<input type="text" name="amount_flt" id="' + key + '_amount" autocomplete="off" data-validator="^\\d*\\.?\\d*$"></div><svg class="line"></svg></div>';
            }
            html += '<div class="d-felx flex-row text-center">';
            var original_likes = web3.utils.fromWei(topic.likes, 'ether');
            var likes = Number(original_likes).toFixedDown(3);
            var original_dislikes = web3.utils.fromWei(topic.dislikes, 'ether');
            var dislikes = Number(original_dislikes).toFixedDown(3);

            html += '<span class="likes-counter like" data-toggle="tooltip" data-placement="bottom" title="' + original_likes + '">' + likes + '</span><button class="btn btn-info btn-gradient-blue btn-glow my-4 ml-auto mr-3 btn-important upvote" data-topicKey=' + key + ' ' + (logged ? '' : 'disabled') + (me !== '' ? '' : ' data-toggle="tooltip" data-placement="bottom" title="Login to vote"') + '><i class="far fa-thumbs-up"></i> Like</button>';
            html += '<span class="likes-counter dislike" data-toggle="tooltip" data-placement="bottom" title="' + original_dislikes + '">' + dislikes + '</span><button class="btn btn-gradient-blue btn-glow my-4 btn-important downvote" data-topicKey=' + key + ' ' + (logged ? '' : 'disabled') + (me !== '' ? '' : ' data-toggle="tooltip" data-placement="bottom" title="Login to vote"') + '><i class="far fa-thumbs-down"></i> Dislike</button>';
            html += '</div>';


            html += '</div></div>';
            if (topic.argument.length > charPostLimit) {
                html += '<a href="/topic.php?t=' + key + '">Read More</a>';
            }
            html += '</div></div>';
            return html;
        }

        function setupBtnListeners() {
            $('.upvote').off('click');
            $('.upvote').click(function(e) {
                e.preventDefault();
                var key = $(this).data('topickey');
                var amount = $('#' + key + '_amount').val();
                if (isNaN(Number(amount)) || Number(amount) <= 0) {
                    alert('Not a valid amount');
                    return;
                }
                $(this).attr('disabled', true);
                amount = web3js.toWei(amount, 'ether');
                upvote(key, amount, $(this));
            });
            $('.downvote').off('click');
            $('.downvote').click(function(e) {
                e.preventDefault();
                var key = $(this).data('topickey');
                var amount = $('#' + key + '_amount').val();
                if (isNaN(Number(amount)) || Number(amount) <= 0) {
                    alert('Not a valid amount');
                    return;
                }
                $(this).attr('disabled', true);
                amount = web3js.toWei(amount, 'ether');
                downvote(key, amount, $(this));
            });
        }

        function getTopicsList() {
            contract.methods.getTopicsCount().call(function(err, count) {
                pages = Math.ceil(count / max_topic_per_page);

                var start = 0;
                var page = <?php echo (int)$page ?>;
                if (count > max_topic_per_page) {
                    start = (count - max_topic_per_page) - (max_topic_per_page * page);
                    count = start + max_topic_per_page;
                }

                for (var i = start; i < count; i++) {
                    contract.methods.getTopicAtIndex(i).call(function(err, topic) {
                        if (typeof topic !== 'undefined')
                            topics[topic.key] = topic;
                        renderTopics();
                    });
                }
                formatPages();
            });
        }

        function renderTopics() {
            for (var key in topics) {
                if ($("#" + key).length)
                    continue;
                var topic = topics[key];
                $("#topics").prepend(generateTopicHTML(key, topic));
                updateDynamicJS(key);
            }
            setupBtnListeners();
        }

        function upvote(topicKey, amount, btn) {
            if (!ethBrowser) {
                alert('Non-Ethereum browser detected. You should consider trying MetaMask!');
                return;
            }
            contractJS.upvote(topicKey, amount, (err, success) => {
                if (!success) {
                    alert('An error occurred, vote cannot be sent');
                    btn.removeAttr('disabled');
                }
            });
        }

        function downvote(topicKey, amount, btn) {
            if (!ethBrowser) {
                alert('Non-Ethereum browser detected. You should consider trying MetaMask!');
                return;
            }
            contractJS.downvote(topicKey, amount, (err, success) => {
                if (!success) {
                    alert('An error occurred, vote cannot be sent');
                    btn.removeAttr('disabled');
                }
            });
        }

        function listenContractEvents() {
            contract.events.NewTopic((err, events) => {
                var topicKey = events.returnValues.topicKey;
                contract.methods.getTopic(topicKey).call(function(err, result) {
                    topics[topicKey] = result;
                    $("#topics").prepend(generateTopicHTML(topicKey, topics[topicKey]));
                    updateDynamicJS(topicKey);
                    setupBtnListeners();
                    $('#newTopic').removeAttr('disabled');
                    $('#newTopicArea').val('');
                    $('#newTopicArea').removeAttr('disabled');
                });
            });

            contract.events.Upvote((err, events) => {
                var topicKey = events.returnValues.topicKey;
                var likes = events.returnValues.likes;
                topics[topicKey].likes = likes;
                $("#" + topicKey).replaceWith(generateTopicHTML(topicKey, topics[topicKey]));
                updateDynamicJS(topicKey);
                setupBtnListeners();
            });

            contract.events.Downvote((err, events) => {
                var topicKey = events.returnValues.topicKey;
                var dislikes = events.returnValues.dislikes;
                topics[topicKey].dislikes = dislikes;
                $("#" + topicKey).replaceWith(generateTopicHTML(topicKey, topics[topicKey]));
                updateDynamicJS(topicKey);
                setupBtnListeners();
            });

            contract.events.Transfer((err, events) => {
                web3.eth.getAccounts((err, accounts) => {
                    contract.methods.balanceOf(accounts[0]).call(function(err, flt) {
                        web3js.eth.getBalance(accounts[0], (err, eth) => {
                            $('#my-wallet').html('My Wallet ' + web3js.fromWei(flt, "ether") + ' FLT - ' + web3js.fromWei(eth, "ether") + " ETH");
                        });
                    });
                });
            });
        }

        function createNewTopic() {
            if (!ethBrowser) {
                alert('Non-Ethereum browser detected. You should consider trying MetaMask!');
                $('#newTopic').removeAttr('disabled');
                $('#newTopicArea').removeAttr('disabled');
                return;
            }
            var argument = $('#newTopicArea').val().trim();
            var topicKey = argument.hash();

            contractJS.newTopic(topicKey, argument, (err, success) => {
                if (!success) {
                    alert('An error occurred, topic cannot be sent');
                    $('#newTopic').removeAttr('disabled');
                    $('#newTopicArea').removeAttr('disabled');
                }
            });
        }

        function formatPages() {
            var html = '';
            var page = <?php echo (int)$page ?>;
            for (var i = 0; i < pages; i++) {
                html += '<li class="page-item ' + (i == page ? 'disabled ' : '') + '"><a class="page-link" href="/topics.php?p=' + i + '">' + (i + 1) + '</a></li>';
            }
            $('.pagination').html(html);
        }

        String.prototype.hashCode = function() {
            var hash = 0,
                i = 0,
                len = this.length;
            while (i < len) {
                hash = ((hash << 5) - hash + this.charCodeAt(i++)) << 0;
            }
            return hash;
        };

        function updateDynamicJS(key) {
            $('[data-toggle="tooltip"]').tooltip();
            styleInput($('#' + key + '_amount').get(0));
        }

        String.prototype.hash = function() {
            return (this.hashCode() + 2147483647) + 1;
        };

        Number.prototype.toFixedDown = function(digits) {
            var re = new RegExp("(\\d+\\.\\d{" + digits + "})(\\d)"),
                m = this.toString().match(re);
            return m ? parseFloat(m[1]) : this.valueOf();
        };

        function copyToClipboard(text, elem) {
            var $temp = $("<input>");
            $(elem).parent().append($temp);
            $temp.attr('contenteditable', 'true');
            $temp.val(text).select();
            var range = document.createRange();
            range.selectNodeContents($temp.get(0));
            var s = window.getSelection();
            s.removeAllRanges();
            s.addRange(range);
            $temp.get(0).setSelectionRange(0, 999999);
            var success = document.execCommand("copy");
            $temp.remove();
            $('#' + $(elem).attr("aria-describedby")).html('<div class="arrow" style="left: 32px;"></div><div class="tooltip-inner">Copied!</div>')
        }
    </script>
</body>

</html>
