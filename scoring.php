<?php
include('db/db-con.php');

include 'login_sessions/user_session.php';
session_start();
$Id = '';
$role = $_SESSION['role'];
$Id = $_COOKIE['Id'];

$agency = $_SESSION['agent'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-cx1GvwI1/PzdBYP1e6/J2H2w95aP+1e0+KlgQCT4Dn2zU5CUIaGq6u1NI7/P3xUkONnH1aDMQ/9cO2Cki5yWeA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
  <!-- //displaydataininput// -->

  <link rel="stylesheet" href="QA/css/qc_scoring.css">
  <?php
    include 'include_file/link.php';
    ?>





<body>

<input type="text" class="dataId" value="<?php echo $Id ?>" hidden />
 <input type="text" class="dataagency" value="<?php echo  $gency ?>" hidden />



  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="results-summary-container codescoringcontainer">
          <div class="confetti  ">

            <div class="confetti-piece"></div>
            <div class="confetti-piece"></div>
            <div class="confetti-piece"></div>
            <div class="confetti-piece"></div>
            <div class="confetti-piece"></div>
            <div class="confetti-piece"></div>

          </div>
          
          <div class="results-summary-container__result">
            <div class="heading-tertiary"> </div>
            <div class="result-box">
              <div class="heading-primary codescore">100</div>
              <p class="result">of 100</p>
            </div>
            <div class="result-text-box">
              <div class="heading-secondary">Score</div>
              <p class="paragraph">
                You scored higher than 65% of the people who have taken these tests.
              </p>
            </div>
          </div>
          <div class="results-summary-container__options">
            <div class="heading-secondary heading-secondary--blue"> CODING</div>
            <div class="summary-result-options">
              <div class="result-option result-option-reaction">
                <div class="icon-box">

                  <span class="reaction-icon-text">Code Segment</span>
                </div>
                <div class="result-box"><span class="codescore">100</span> / 100</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="results-summary-container oasisscoringcontainer">
          <div class="confetti  ">

            <div class="confetti-piece"></div>
            <div class="confetti-piece"></div>
            <div class="confetti-piece"></div>
            <div class="confetti-piece"></div>
            <div class="confetti-piece"></div>
            <div class="confetti-piece"></div>

          </div>
          <div class="results-summary-container__result">
            <div class="heading-tertiary"> </div>
            <div class="result-box">
              <div class="heading-primary oasisscore">100</div>
              <p class="result">of 100</p>
            </div>
            <div class="result-text-box">
              <div class="heading-secondary">Score</div>
              <p class="paragraph">
                You scored higher than 65% of the people who have taken these tests.
              </p>
            </div>
          </div>
          <div class="results-summary-container__options">
            <div class="heading-secondary heading-secondary--blue"> OASIS</div>
            <div class="summary-result-options">
              <div class="result-option result-option-memory">
                <div class="icon-box">
                  <span class="memory-icon-text">Oasis Segment</span>
                </div>
                <div class="result-box"><span class="oasisscore">100</span> / 100</div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-12" id="pocscoringcontainer">
        <div class="results-summary-container pocscoringcontainer">
          <div class="confetti  ">

            <div class="confetti-piece"></div>
            <div class="confetti-piece"></div>
            <div class="confetti-piece"></div>
            <div class="confetti-piece"></div>
            <div class="confetti-piece"></div>
            <div class="confetti-piece"></div>

          </div>
          <div class="results-summary-container__result">
            <div class="heading-tertiary"> </div>
            <div class="result-box">
              <div class="heading-primary pocscore">100</div>
              <p class="result">of 100</p>
            </div>
            <div class="result-text-box">
              <div class="heading-secondary">Score</div>

            </div>
          </div>
          <div class="results-summary-container__options">
            <div class="heading-secondary heading-secondary--blue"> POC</div>
            <div class="summary-result-options">
              <div class="result-option result-option-verbal">
                <div class="icon-box">
                  <span class="verbal-icon-text">Poc Segment</span>
                </div>
                <div class="result-box"><span class="pocscore">100</span> / 100</div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-12" id="overallscoringcontainer">
        <div class="results-summary-container">
          <div class="confetti  ">

            <div class="confetti-piece"></div>
            <div class="confetti-piece"></div>
            <div class="confetti-piece"></div>
            <div class="confetti-piece"></div>
            <div class="confetti-piece"></div>
            <div class="confetti-piece"></div>

          </div>
          <div class="results-summary-container__result">
            <div class="heading-tertiary"> </div>
            <div class="result-box">
              <div class="heading-primary totalscore">100</div>
              <p class="result">of 100</p>
            </div>
            <div class="result-text-box">
              <div class="heading-secondary" style="font-size: 20px;">average</div>

            </div>
          </div>
          <div class="results-summary-container__options">
            <div class="heading-secondary heading-secondary--blue" style="font-size: 20px;"> Overall Quality

            </div>
            <div class="summary-result-options">
              <div class="result-option result-option-reaction codescoreshowing">
                <div class="icon-box">

                  <span class="reaction-icon-text">Code Segment</span>
                </div>
                <div class="result-box "><span class="codescore ">100</span> / 100</div>
              </div>
              <div class="result-option result-option-memory oasisscoreshowing">
                <div class="icon-box">
                  <span class="memory-icon-text">Oasis Segment</span>
                </div>
                <div class="result-box "><span class="oasisscore ">100</span> / 100</div>
              </div>
              <div class="result-option result-option-verbal pocscoreshowing">
                <div class="icon-box ">
                  <span class="verbal-icon-text">Poc Segment</span>
                </div>
                <div class="result-box"><span class="pocscore ">100</span> / 100</div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


 <?php $randomnum = rand(0000, 9999); ?>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="QA/js/qc_scoring.js?<?php echo $randomnum; ?>"></script>