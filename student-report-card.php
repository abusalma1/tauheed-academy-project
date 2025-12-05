<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pupil's Report Sheet - Tauheed Academy</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: "Times New Roman", Times, serif;
      background: white;
      padding: 0;
    }

    .a4-page {
      width: 210mm;
      height: 297mm;
      padding: 12mm;
      margin: 0 auto;
      background: white;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      font-size: 11px;
      line-height: 1.3;
      overflow: hidden;
    }

    /* Header Section */
    .header {
      text-align: center;
      border-bottom: 3px solid #000;
      padding-bottom: 8px;
      margin-bottom: 8px;
    }

    .school-name {
      font-size: 18px;
      font-weight: bold;
      letter-spacing: 2px;
      margin-bottom: 2px;
    }

    .school-address {
      font-size: 9px;
      margin-bottom: 4px;
    }

    .report-sheet-box {
      border: 2px solid #000;
      display: inline-block;
      padding: 4px 20px;
      margin: 4px 0;
      font-size: 12px;
      font-weight: bold;
    }

    /* Student Info Row */
    .info-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 6px;
      font-size: 10px;
    }

    .info-item {
      flex: 1;
      display: flex;
      align-items: center;
      gap: 4px;
    }

    .info-label {
      font-weight: bold;
      min-width: 70px;
    }

    .info-value {
      border-bottom: 1px solid #000;
      flex: 1;
      padding: 0 4px;
    }

    /* Cognitive Activity Section */
    .section-title {
      font-weight: bold;
      font-size: 10px;
      margin-top: 6px;
      margin-bottom: 4px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 6px;
      font-size: 10px;
    }

    th,
    td {
      border: 1px solid #000;
      padding: 4px;
      text-align: center;
      height: 20px;
    }

    th {
      font-weight: bold;
      background: white;
    }

    td {
      background: white;
    }

    .subject-col {
      text-align: left;
      font-weight: bold;
    }

    .total-row {
      font-weight: bold;
    }

    /* Two Column Layout */
    .two-column {
      display: flex;
      gap: 12px;
      margin-bottom: 6px;
    }

    .column {
      flex: 1;
    }

    .wide-column {
      flex: 1.2;
    }

    /* Attendance Table */
    .attendance-table {
      width: 100%;
      border-collapse: collapse;
    }

    .attendance-table th,
    .attendance-table td {
      border: 1px solid #000;
      padding: 3px;
      font-size: 9px;
      height: 18px;
    }

    /* Psychomotor Skills Table */
    .psychomotor-table {
      width: 100%;
      border-collapse: collapse;
    }

    .psychomotor-table th,
    .psychomotor-table td {
      border: 1px solid #000;
      padding: 3px;
      font-size: 9px;
      height: 18px;
    }

    .skill-name {
      text-align: left;
      font-weight: bold;
    }

    /* Affective Areas */
    .affective-table {
      width: 100%;
      border-collapse: collapse;
    }

    .affective-table th,
    .affective-table td {
      border: 1px solid #000;
      padding: 3px;
      font-size: 9px;
      height: 18px;
      text-align: center;
    }

    .affective-label {
      text-align: left;
      font-weight: bold;
    }

    /* Grading Scale */
    .grading-scale {
      width: 100%;
      border-collapse: collapse;
    }

    .grading-scale th,
    .grading-scale td {
      border: 1px solid #000;
      padding: 3px;
      font-size: 9px;
      height: 18px;
    }

    /* Bottom Section */
    .footer {
      margin-top: 6px;
      font-size: 9px;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
    }

    .comment-line {
      display: flex;
      margin-bottom: 3px;
      align-items: center;
    }

    .comment-label {
      font-weight: bold;
      min-width: 120px;
    }

    .comment-text {
      flex: 1;
      border-bottom: 1px solid #000;
      padding: 0 4px;
    }

    .signature-line {
      border-bottom: 1px solid #000;
      width: 50px;
      height: 18px;
      margin-left: auto;
    }

    .scale-note {
      font-size: 8px;
      margin: 2px 0;
    }

    @page {
      margin: 0;
    }

    body {
      margin: 0;
    }
  </style>
</head>

<body>
  <div class="a4-page" id="result-1">
    <!-- Header -->
    <div class="header">
      <div class="school-name">TAUHEED ACADEMY</div>
      <div class="school-address">
        No.1 Tsafi Road, Gidan Madawaki Isah<br />
        Opp. Sultan Abubakar III Jumu'at Mosque, Sokoto
      </div>
      <div class="report-sheet-box">Pupil's Report Sheet</div>
    </div>

    <!-- Student Info -->
    <div class="info-row">
      <div class="info-item" style="flex: 1.5">
        <span class="info-label">NAME:</span>
        <span class="info-value">AMATULLAH ABUBAKAR JODI</span>
      </div>
      <div class="info-item">
        <span class="info-label">CLASS:</span>
        <span class="info-value">Nur. 3</span>
      </div>
    </div>

    <div class="info-row">
      <div class="info-item" style="flex: 1.2">
        <span class="info-label">AVERAGE:</span>
        <span class="info-value">95.8</span>
      </div>
      <div class="info-item" style="flex: 1.2">
        <span class="info-label">NUMBER OF PUPILS IN CLASS</span>
        <span class="info-value">21</span>
      </div>
      <div class="info-item">
        <span class="info-label">TERM:</span>
        <span class="info-value">3rd</span>
      </div>
    </div>

    <!-- Section 1: Cognitive Activity -->
    <div class="section-title">1. COGNITIVE ACTIVITY</div>
    <table>
      <thead>
        <tr>
          <th style="text-align: left">SUBJECTS</th>
          <th>1<sup>ST</sup> CA<br />20%</th>
          <th>2<sup>ND</sup> CA<br />20%</th>
          <th>EXAM<br />60%</th>
          <th>CUMM.<br />MARKS 100%</th>
          <th>GRADE</th>
          <th style="text-align: left">TEACHER'S<br />REMARK</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="subject-col">ENGLISH STUDIES</td>
          <td>20</td>
          <td>20</td>
          <td>60</td>
          <td>100</td>
          <td>A</td>
          <td style="text-align: left">Excellent</td>
        </tr>
        <tr>
          <td class="subject-col">MATHEMATICS</td>
          <td>20</td>
          <td>20</td>
          <td>60</td>
          <td>100</td>
          <td>A</td>
          <td style="text-align: left">Excellent</td>
        </tr>
        <tr>
          <td class="subject-col">BASIC SCIENCE</td>
          <td>20</td>
          <td>20</td>
          <td>60</td>
          <td>100</td>
          <td>A</td>
          <td style="text-align: left">Excellent</td>
        </tr>
        <tr>
          <td class="subject-col">GENERAL KNOWLEDGE</td>
          <td>20</td>
          <td>20</td>
          <td>60</td>
          <td>100</td>
          <td>A</td>
          <td style="text-align: left">Excellent</td>
        </tr>
        <tr>
          <td class="subject-col">PHONICS AND RHYMES</td>
          <td>20</td>
          <td>20</td>
          <td>60</td>
          <td>100</td>
          <td>A</td>
          <td style="text-align: left">Excellent</td>
        </tr>
        <tr>
          <td class="subject-col">HAND WRITING</td>
          <td>15</td>
          <td>15</td>
          <td>45</td>
          <td>75</td>
          <td>A</td>
          <td style="text-align: left">Excellent</td>
        </tr>
        <tr class="total-row">
          <td style="text-align: left"></td>
          <td></td>
          <td></td>
          <td></td>
          <td>575</td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>

    <!-- Two Column Section: Attendance + Psychomotor -->
    <div class="two-column">
      <div class="column">
        <div class="section-title">2. ATTENDANCE</div>
        <table class="attendance-table">
          <tbody>
            <tr>
              <td style="font-weight: bold; text-align: left">Frequencies</td>
              <td style="font-weight: bold">School attended</td>
            </tr>
            <tr>
              <td style="text-align: left">Number of Times School Opened</td>
              <td>86</td>
            </tr>
            <tr>
              <td style="text-align: left">Number of Times Present</td>
              <td>92</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="column">
        <div class="section-title">3. PHYSYCHOMOTOR SKILLS</div>
        <table class="psychomotor-table">
          <tbody>
            <tr>
              <td class="skill-name">Verbal fluency</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="skill-name">Sports</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="skill-name">Games</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="skill-name">Drawing painting</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="skill-name">Musical skills</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Two Column Section: Affective Areas + Grading Scale -->
    <div class="two-column">
      <div class="column">
        <div class="section-title">4. AFFECTIVE AREAS</div>
        <table class="affective-table">
          <thead>
            <tr>
              <th style="text-align: left">Attributes</th>
              <th>5</th>
              <th>4</th>
              <th>3</th>
              <th>2</th>
              <th>1</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="affective-label">Punctuality</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="affective-label">Neatness</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="affective-label">Politeness</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="affective-label">Honesty</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="affective-label">Cooperation in school</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="affective-label">Attentiveness</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="affective-label">Leadership</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="wide-column">
        <div class="scale-note" style="margin-bottom: 4px">
          Scale 5- EXCELLENT 4- GOOD 3- FAIR 2- POOR 1- VERY POOR
        </div>
        <table class="grading-scale">
          <thead>
            <tr>
              <th style="text-align: center">Scores</th>
              <th style="text-align: center">Grade</th>
              <th style="text-align: center">Remark</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>75 - 100</td>
              <td>A</td>
              <td>EXCELLENT</td>
            </tr>
            <tr>
              <td>60 - 74</td>
              <td>B</td>
              <td>V.GOOD</td>
            </tr>
            <tr>
              <td>50 - 59</td>
              <td>C</td>
              <td>GOOD</td>
            </tr>
            <tr>
              <td>40 - 49</td>
              <td>D</td>
              <td>FAIR</td>
            </tr>
            <tr>
              <td>0 - 39</td>
              <td>E</td>
              <td>POOR</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Footer -->
    <div class="footer">
      <div class="comment-line">
        <span class="comment-label">CLASS TEACHERS COMMENT:</span>
        <span class="comment-text">An excellent result keep it up</span>
      </div>
      <div class="comment-line">
        <span class="comment-label">NEXT TERM BEGINS</span>
        <span class="comment-text">8th Sept. 2025</span>
        <span class="comment-label" style="margin-left: 20px">NEXT TERM FEES</span>
        <span class="comment-text">First Term N₦6000/</span>
      </div>
      <div class="comment-line">
        <span class="comment-label">HEAD TEACHERS COMMENT:</span>
        <span class="comment-text">An impressive result keep it up</span>
        <span style="margin-left: 40px; font-weight: bold">Signature:</span>
        <div class="signature-line"></div>
      </div>
    </div>
  </div>

  <button onclick="printDiv('result-1')">Print This Div</button>

  <script>
    function printDiv(divId) {
      var divContent = document.getElementById(divId).outerHTML;
      var printWindow = window.open('', '', 'height=600,width=800');

      // Add your CSS link here
      printWindow.document.write('<html><head><title>Print</title>');
      printWindow.document.write('<link rel="stylesheet" href="styles.css">');
      printWindow.document.write('<style>@page { margin:0; } body { margin:20px; }</style>');
      printWindow.document.write('</head><body>');
      printWindow.document.write(divContent);
      printWindow.document.write('</body></html>');

      printWindow.document.close();
      printWindow.focus();
      printWindow.print();
      printWindow.close();
    }
  </script>
</body>

</html>