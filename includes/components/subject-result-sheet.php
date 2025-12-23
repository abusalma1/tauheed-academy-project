<div class="hidden" style="
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
    <div style="width:100%; padding-left: 5px;  padding-right: 5px;" id="result">

        <!-- HEADER -->
        <div style="text-align:center; border-bottom:3px solid #000; padding-bottom:8px; margin-bottom:8px;">
            <div style="font-size:23px; font-weight:bold;"><?= strtoupper($school['name']) ?></div>
            <div style="
                                font-size:13px;
                                margin-top:5px;
                                width:350px;
                                margin-left:auto;
                                margin-right:auto;
                                text-align:center;
                                white-space:normal;
                                word-wrap:break-word;
                                ">
                <?= $school['address'] ?>
            </div>


            <div style="border:2px solid #000; display:inline-block; padding:6px 20px; margin-top:10px; font-weight:bold; font-size:20px;">
                Class Result Sheet
            </div>
        </div>

        <!-- STUDENT INFO -->
        <table style="width:100%; border-collapse:collapse; margin-bottom:10px;">
            <tr>
                <td style="font-weight:bold; width:40px; font-size: 11px;">Subject:</td>
                <td style="border-bottom:1px solid #000;"><?= $subject['name'] ?></td>

                <td style="font-weight:bold; width:20px; font-size: 11px;">CLASS:</td>
                <td style="border-bottom:1px solid #000; "><?= $class['name'] . ' ' . $arm['name']  ?></td>

            </tr>
        </table>

        <table style="width:100%; border-collapse:collapse; margin-bottom:10px; font-size:11px;">
            <tr>

                <td style="font-weight:bold; width:40px; font-size: 11px;">TERM:</td>
                <td style="border-bottom:1px solid #000; text-align:center; "> <?= htmlspecialchars($term['name']) ?>
                </td>
                <td style="font-weight:bold; width:40px; font-size: 11px;">SESSION:</td>
                <td style="border-bottom:1px solid #000; text-align:center; "> <?= htmlspecialchars($session['name']) ?>
                </td>
            </tr>
        </table>


        <!-- COGNITIVE ACTIVITY -->

        <table style="width:100%; border-collapse:collapse; font-size:11px; margin-bottom:12px;">
            <tr>
                <th style="border:1px solid #000; padding:6px; text-align:left;">STUDENTS</th>
                <th style="border:1px solid #000; padding:6px; text-align:left;">ADM NO.</th>
                <th style="border:1px solid #000; padding:6px;">CA</th>
                <th style="border:1px solid #000; padding:6px;">EXAM</th>
                <th style="border:1px solid #000; padding:6px;">TOTAL</th>
                <th style="border:1px solid #000; padding:6px;">GRADE</th>
                <th style="border:1px solid #000; padding:6px;">REMARK</th>
            </tr>

            <!-- SUBJECT ROWS -->
            <?php foreach ($students as $student): ?>

                <tr>
                    <td style="border:1px solid #000; padding:6px;"><?= $student['name'] ?></td>
                    <td style="border:1px solid #000;  text-align:center; "><?= $student['admission_number'] ?></td>
                    <td style="border:1px solid #000;  text-align:center;"><?= $student['ca'] ?></td>
                    <td style="border:1px solid #000;  text-align:center;"><?= $student['exam'] ?></td>
                    <td style="border:1px solid #000;  text-align:center;"><?= $student['total'] ?></td>
                    <td style="border:1px solid #000;  text-align:center;"><?= $student['grade'] ?></td>
                    <td style="border:1px solid #000;  text-align:center;"><?= $student['remark'] ?></td>
                </tr>
            <?php endforeach ?>
        </table>



    </div> <!-- end A4 container -->

</div>