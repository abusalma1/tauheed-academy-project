<?php
include(__DIR__ . '/../routes/functions.php');
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Pupil's Report Sheet</title>
  <style>
    @page {
      size: A4;
      margin: 20px;
    }
  </style>
</head>

<body style="font-family: Helvetica, sans-serif; font-size:15px;">
  <div style="
    width:210mm;
    height:297mm;
    margin-left:auto;
    margin-right:auto;
    background:white;
    padding:10mm;
    box-sizing:border-box;
    border: 1px solid black;
">
    <!-- A4 Container -->
    <div style="width:100%; padding-left: 5px;  padding-right: 5px;" id="result-1">

      <!-- HEADER -->
      <div style="text-align:center; border-bottom:3px solid #000; padding-bottom:8px; margin-bottom:8px;">
        <div style="font-size:23px; font-weight:bold;">TAUHEED ACADEMY</div>
        <div style="font-size:13px; margin-top:5px;">
          No.1 Tsafe Road, Gidan Madawaki Isah<br>
          Opp. Sultan Abubakar III Jumu'at Mosque, Sokoto
        </div>
        <div style="border:2px solid #000; display:inline-block; padding:6px 20px; margin-top:10px; font-weight:bold; font-size:20px;">
          Pupil's Report Sheet
        </div>
      </div>

      <!-- STUDENT INFO -->
      <table style="width:100%; border-collapse:collapse; margin-bottom:10px;">
        <tr>
          <td style="font-weight:bold; width:40px; font-size: 11px;">NAME:</td>
          <td style="border-bottom:1px solid #000;">AMATULLAH ABUBAKAR JODI</td>

          <td style="font-weight:bold; width:40px; font-size: 11px;">CLASS:</td>
          <td style="border-bottom:1px solid #000; ">Nur. 3</td>
          <td style="font-weight:bold; width:40px; font-size: 11px;">TERM:</td>
          <td style="border-bottom:1px solid #000; width:60px;">3rd</td>
          <td style="font-weight:bold; width:40px; font-size: 11px;">SESSION:</td>
          <td style="border-bottom:1px solid #000; width:60px;">2022/2023</td>
        </tr>
      </table>

      <table style="width:100%; border-collapse:collapse; margin-bottom:10px;">
        <tr>

          <!-- Position -->
          <td style="font-weight:bold;  font-size:11px; width:10px;">POSITION:</td>
          <td style="border-bottom:1px solid #000 ;   text-align:center; width:60px;">
            <?= ordinal(4) ?>
          </td>

          <!-- Number of pupils -->
          <td style="font-weight:bold; font-size:11px; width:115px;">NUMBER IN CLASS:</td>
          <td style="border-bottom:1px solid #000;  text-align:center; width:60px;">21</td>

          <!-- 1st Term -->
          <td style="font-weight:bold; font-size:11px; width:40px; text-align:center;">1st Avg</td>
          <td style="border-bottom:1px solid #000; text-align:center;">85.4</td>

          <!-- 2nd Term -->
          <td style="font-weight:bold; font-size:11px; width:43px; text-align:center;">2nd Avg</td>
          <td style="border-bottom:1px solid #000; text-align:center;">90.2</td>

          <!-- 3rd Term -->
          <td style="font-weight:bold; font-size:11px; width:42px; text-align:center;">3rd Avg</td>
          <td style="border-bottom:1px solid #000; text-align:center;">95.8</td>

          <!-- Total Class Average -->
          <td style="font-weight:bold; font-size:11px; width:60px; text-align:center;">Class Avg</td>
          <td style="border-bottom:1px solid #000;  text-align:center;">90.5</td>

        </tr>
      </table>


      <!-- COGNITIVE ACTIVITY -->
      <div style="font-weight:bold; margin:6px 0 4px 0;">1. COGNITIVE ACTIVITY</div>

      <table style="width:100%; border-collapse:collapse; font-size:11px; margin-bottom:12px;">
        <tr>
          <th style="border:1px solid #000; padding:6px; text-align:left;">SUBJECTS</th>
          <th style="border:1px solid #000; padding:6px;">1ST CA</th>
          <th style="border:1px solid #000; padding:6px;">2ND CA</th>
          <th style="border:1px solid #000; padding:6px;">EXAM</th>
          <th style="border:1px solid #000; padding:6px;">TOTAL</th>
          <th style="border:1px solid #000; padding:6px;">GRADE</th>
          <th style="border:1px solid #000; padding:6px; text-align:left;">REMARK</th>
        </tr>

        <!-- SUBJECT ROWS -->
        <tr>
          <td style="border:1px solid #000; padding:6px; font-weight:bold;">ENGLISH STUDIES</td>
          <td style="border:1px solid #000;">20</td>
          <td style="border:1px solid #000;">20</td>
          <td style="border:1px solid #000;">60</td>
          <td style="border:1px solid #000;">100</td>
          <td style="border:1px solid #000;">A</td>
          <td style="border:1px solid #000;">Excellent</td>
        </tr>

        <tr>
          <td style="border:1px solid #000; padding:6px; font-weight:bold;">MATHEMATICS</td>
          <td style="border:1px solid #000;">20</td>
          <td style="border:1px solid #000;">20</td>
          <td style="border:1px solid #000;">60</td>
          <td style="border:1px solid #000;">100</td>
          <td style="border:1px solid #000;">A</td>
          <td style="border:1px solid #000;">Excellent</td>
        </tr>

        <tr>
          <td style="border:1px solid #000; padding:6px; font-weight:bold;">BASIC SCIENCE</td>
          <td style="border:1px solid #000;">20</td>
          <td style="border:1px solid #000;">20</td>
          <td style="border:1px solid #000;">60</td>
          <td style="border:1px solid #000;">100</td>
          <td style="border:1px solid #000;">A</td>
          <td style="border:1px solid #000;">Excellent</td>
        </tr>

        <tr>
          <td style="border:1px solid #000; padding:6px; font-weight:bold;">GENERAL KNOWLEDGE</td>
          <td style="border:1px solid #000;">20</td>
          <td style="border:1px solid #000;">20</td>
          <td style="border:1px solid #000;">60</td>
          <td style="border:1px solid #000;">100</td>
          <td style="border:1px solid #000;">A</td>
          <td style="border:1px solid #000;">Excellent</td>
        </tr>

        <tr>
          <td style="border:1px solid #000; padding:6px; font-weight:bold;">PHONICS AND RHYMES</td>
          <td style="border:1px solid #000;">20</td>
          <td style="border:1px solid #000;">20</td>
          <td style="border:1px solid #000;">60</td>
          <td style="border:1px solid #000;">100</td>
          <td style="border:1px solid #000;">A</td>
          <td style="border:1px solid #000;">Excellent</td>
        </tr>

        <tr>
          <td style="border:1px solid #000; padding:6px; font-weight:bold;">HAND WRITING</td>
          <td style="border:1px solid #000;">15</td>
          <td style="border:1px solid #000;">15</td>
          <td style="border:1px solid #000;">45</td>
          <td style="border:1px solid #000;">75</td>
          <td style="border:1px solid #000;">A</td>
          <td style="border:1px solid #000;">Excellent</td>
        </tr>
        <tr>
          <td style="border:1px solid #000; padding:6px; font-weight:bold;">HAND WRITING</td>
          <td style="border:1px solid #000;">15</td>
          <td style="border:1px solid #000;">15</td>
          <td style="border:1px solid #000;">45</td>
          <td style="border:1px solid #000;">75</td>
          <td style="border:1px solid #000;">A</td>
          <td style="border:1px solid #000;">Excellent</td>
        </tr>
        <tr>
          <td style="border:1px solid #000; padding:6px; font-weight:bold;">HAND WRITING</td>
          <td style="border:1px solid #000;">15</td>
          <td style="border:1px solid #000;">15</td>
          <td style="border:1px solid #000;">45</td>
          <td style="border:1px solid #000;">75</td>
          <td style="border:1px solid #000;">A</td>
          <td style="border:1px solid #000;">Excellent</td>
        </tr>
        <tr>
          <td style="border:1px solid #000; padding:6px; font-weight:bold;">HAND WRITING</td>
          <td style="border:1px solid #000;">15</td>
          <td style="border:1px solid #000;">15</td>
          <td style="border:1px solid #000;">45</td>
          <td style="border:1px solid #000;">75</td>
          <td style="border:1px solid #000;">A</td>
          <td style="border:1px solid #000;">Excellent</td>
        </tr>

        <tr>
          <td style="border:none;"></td>
          <td style="border:none;"></td>
          <td style="border:none;"></td>
          <td style="border:none;"></td>
          <td style="border:1px solid #000; text-align:center;">575</td>
          <td style="border:none;"></td>
          <td style="border:none;"></td>
        </tr>
      </table>

      <!-- ATTENDANCE + PSYCHOMOTOR -->
      <table style="width:100%; border-collapse:collapse; margin-bottom:8px;">
        <tr>

          <!-- Attendance -->
          <td style="width:50%; vertical-align:top;">
            <div style="font-weight:bold; margin-bottom:7px;">2. ATTENDANCE</div>
            <table style="width:100%; border-collapse:collapse; font-size:12px;">
              <tr>
                <td style="border:1px solid #000; font-weight:bold;padding:3px 5px; ">Frequencies</td>
                <td style="border:1px solid #000; font-weight:bold; padding:3px 5px;">School attended</td>
              </tr>
              <tr>
                <td style="border:1px solid #000; padding:3px 5px;">Number of Times School Opened</td>
                <td style="border:1px solid #000; text-align:center;">86</td>
              </tr>
              <tr>
                <td style="border:1px solid #000; padding:3px 5px;">Number of Times Present</td>
                <td style="border:1px solid #000; text-align:center;">92</td>
              </tr>
            </table>
          </td>

          <!-- Psychomotor -->
          <td style="width:50%; vertical-align:top;">
            <div style="font-weight:bold; margin-bottom:7px;">3. PSYCHOMOTOR SKILLS</div>
            <table style="width:100%; border-collapse:collapse; font-size:11px;">
              <tr>
                <td style="border:1px solid #000; padding:3px 5px;">Verbal fluency</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
              </tr>
              <tr>
                <td style="border:1px solid #000; padding:3px 5px;">Sports</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
              </tr>
              <tr>
                <td style="border:1px solid #000; padding:3px 5px;">Games</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
              </tr>
              <tr>
                <td style="border:1px solid #000; padding:3px 5px;">Drawing painting</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
              </tr>
              <tr>
                <td style="border:1px solid #000; padding:3px 5px;">Musical skills</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
              </tr>
            </table>
          </td>

        </tr>
      </table>

      <!-- AFFECTIVE AREAS + GRADING SCALE -->
      <table style="width:100%; border-collapse:collapse; margin-bottom:8px;">
        <tr>

          <!-- Affective Areas -->
          <td style="width:50%; vertical-align:top;">
            <div style="font-weight:bold; margin-bottom:7px;">4. AFFECTIVE AREAS</div>
            <table style="width:100%; border-collapse:collapse; font-size:10px;">
              <tr>
                <th style="border:1px solid #000; text-align:left; padding:3px 5px;">Attributes</th>
                <th style="border:1px solid #000;">5</th>
                <th style="border:1px solid #000;">4</th>
                <th style="border:1px solid #000;">3</th>
                <th style="border:1px solid #000;">2</th>
                <th style="border:1px solid #000;">1</th>
              </tr>

              <tr>
                <td style="border:1px solid #000; padding:3px 5px;">Punctuality</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
              </tr>

              <tr>
                <td style="border:1px solid #000; padding:3px 5px;">Neatness</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
              </tr>

              <tr>
                <td style="border:1px solid #000; padding:3px 5px;">Politeness</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
              </tr>

              <tr>
                <td style="border:1px solid #000; padding:3px 5px;">Honesty</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
              </tr>

              <tr>
                <td style="border:1px solid #000; padding:3px 5px;">Cooperation in school</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
              </tr>

              <tr>
                <td style="border:1px solid #000; padding:3px 5px;">Attentiveness</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
              </tr>

              <tr>
                <td style="border:1px solid #000; padding:3px 5px;">Leadership</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
                <td style="border:1px solid #000;">&nbsp;</td>
              </tr>
            </table>
          </td>

          <!-- Grading Scale -->
          <td style="width:50%; vertical-align:top;">
            <div style="font-size:11px; margin-top: 5px; margin-bottom:7px;">
              Scale: 5-EXCELLENT, 4-GOOD, 3-FAIR, 2-POOR, 1-VERY POOR
            </div>

            <table style="width:100%; border-collapse:collapse; font-size:10px;">
              <tr>
                <th style="border:1px solid #000; padding:3px 5px;">Scores</th>
                <th style="border:1px solid #000; padding:3px 5px;">Grade</th>
                <th style="border:1px solid #000; padding:3px 5px;">Remark</th>
              </tr>
              <tr>
                <td style="border:1px solid #000; padding:3px 5px;">75 - 100</td>
                <td style="border:1px solid #000; padding:3px 5px;">A</td>
                <td style="border:1px solid #000; padding:3px 5px;">EXCELLENT</td>
              </tr>
              <tr>
                <td style="border:1px solid #000; padding:3px 5px;">60 - 74</td>
                <td style="border:1px solid #000; padding:3px 5px;">B</td>
                <td style="border:1px solid #000; padding:3px 5px;">V.GOOD</td>
              </tr>
              <tr>
                <td style="border:1px solid #000; padding:3px 5px;">50 - 59</td>
                <td style="border:1px solid #000; padding:3px 5px;">C</td>
                <td style="border:1px solid #000; padding:3px 5px;">GOOD</td>
              </tr>
              <tr>
                <td style="border:1px solid #000; padding:3px 5px;">40 - 49</td>
                <td style="border:1px solid #000; padding:3px 5px;">D</td>
                <td style="border:1px solid #000; padding:3px 5px;">FAIR</td>
              </tr>
              <tr>
                <td style="border:1px solid #000; padding:3px 5px;">0 - 39</td>
                <td style="border:1px solid #000; padding:3px 5px;">E</td>
                <td style="border:1px solid #000; padding:3px 5px;">POOR</td>
              </tr>
            </table>
          </td>

        </tr>
      </table>

      <!-- FOOTER -->
      <div style="margin-top:20px; font-size:13px;">
        <table style="width:100%; border-collapse:collapse; margin-bottom:12px;">
          <tr>
            <td style="font-weight:bold; width:140px;">PROMOTION STATUS:</td>
            <td style="border-bottom:1px solid   #000;">
              Promoted to Primary 1
            </td>
          </tr>
        </table>

        <table style="width:100%; border-collapse:collapse; margin-bottom:12px;">
          <tr>
            <td style="font-weight:bold; width:200px; ">CLASS TEACHER'S COMMENT:</td>
            <td style="border-bottom:1px solid #000;">An excellent result keep it up</td>
          </tr>
        </table>

        <table style="width:100%; border-collapse:collapse; margin-bottom:12px;">
          <tr>
            <td style="font-weight:bold; width:135px;">NEXT TERM BEGINS:</td>
            <td style="border-bottom:1px solid #000; ">8th Sept. 2025</td>

            <td style="font-weight:bold; width:120px;">NEXT TERM FEES:</td>
            <td style="border-bottom:1px solid #000; ">₦76,000</td>
          </tr>
        </table>
        <table style="width:100%; border-collapse:collapse; margin-bottom:12px;">
          <tr>
            <td style="font-weight:bold; width:200px;">HEAD TEACHER'S COMMENT:</td>
            <td style="border-bottom:1px solid #000;">An impressive result keep it up</td>
          </tr>
        </table>

        <table style="width:100%; border-collapse:collapse; margin-bottom:6px;">
          <tr>
            <td style="font-weight:bold; width:100px;">Signature:</td>
            <td style="border-bottom:1px solid #000; width:120px;"></td>
            <td style="text-align:right; font-weight:bold;">Date:</td>
            <td style="border-bottom:1px solid #000; width:80px;">Mar 2025</td>
          </tr>
        </table>

      </div> <!-- end footer -->

    </div> <!-- end A4 container -->

  </div>
  <button onclick="printDiv('result-1')">Print This Div</button>

  <script>
    function printDiv(divId) {
      // Grab only the div content
      var html = document.getElementById(divId).outerHTML;

      // Send to PHP
      fetch("<?= route('print') ?>", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: 'html=' + encodeURIComponent(html)
        })
        .then(response => response.blob())
        .then(blob => {
          var url = window.URL.createObjectURL(blob);
          window.open(url); // open PDF in new tab
        });
    }
  </script>
</body>

</html>