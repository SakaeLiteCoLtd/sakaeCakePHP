
Private Sub checKBunpu_Click()
    Dim insertString As String
    Dim updateCheckKouteiString As String
    Dim values As String

    Dim endRow As Long
    endRow = Range("H65536").End(xlUp).Row


    ' データベースへの接続を確認
    Dim Status As Long
    If P_CheckDatabase() = False Then    ' データベースに接続していない？
        Status = P_OpenDatabase  ' データベースへ接続
        If Status = 0 Then
            Range("A1").Font.Color = RGB(255, 0, 0)     ' 赤色で文字列表示
            Range("A1").Value = "データベース接続中"
        Else
            Range("A1").Font.Color = RGB(255, 0, 0)     ' 赤色で文字列表示
            Range("A1").Value = "データベース接続エラー"
            Exit Sub
        End If
    End If
    Set Rs = New ADODB.Recordset        ' RecordSetオブジェクトの初期化
    Dim product_id As String
    product_id = Range("G2").Value
    Dim lot_num As String
    lot_num = Cells(endRow, 6).Value
    Dim emp As String
    emp = Cells(endRow, 1).Value

    values = " values ('" & product_id & "','" & lot_num & "','" & emp & "','" & Now & "')"
    Dim insertCheckKoutei As String
    selectCheckKoutei = "SELECT id from check_koutei where product_id = '" & product_id & "' and lot_num = '" & lot_num & "'"
    Set Rs = Cn.Execute(selectCheckKoutei)
    If Rs.EOF Then
        MsgBox "工程チェックがされていません。工程チェックをおこなってください。"
        Exit Sub
    Else
        Dim checkKouteiId As Long
        checkKouteiId = Rs.Fields(0).Value
    End If

    If Range("Y3").Value = "" Then
        MsgBox "このシートの分布状況が空欄です。"
        Exit Sub
    End If

    Dim kikakuGyo As Long
    Dim kikakuCol As Long
    Dim startCol

    kikakuGyo = 5 '5行目が規格名
    startCol = 8  '8列目が始まりの列
    kikakuCol = startCol

    Dim flagHantei As Long
    flagHantei = 0

    Do While Worksheets("工程検査結果").Cells(kikakuGyo, kikakuCol).Value <> ""

        Worksheets("規格" & Cells(kikakuGyo, kikakuCol).Value).Activate
        If ActiveSheet.Range("X2").Value = "" Then
            MsgBox "規格" & Cells(kikakuGyo, kikakuCol).Value & "シートの分布状況が判断されていません。"
            Exit Sub
        Else
            If ActiveSheet.Range("X2").Value = "正常" Then

            ElseIf ActiveSheet.Range("X2").Value = "異常" Then
                If flagHantei = 0 Then
                    flagHantei = 1
                End If
            ElseIf ActiveSheet.Range("X2").Value = "不合格品" Then
                flagHantei = 2
            End If

        End If
        kikakuCol = kikakuCol + 1
    Loop

    Worksheets("単重").Activate
    If ActiveSheet.Range("X2").Value = "" Then
        MsgBox "単重シートの分布状況が判断されていません。"
        Exit Sub
    Else
        If ActiveSheet.Range("X2").Value = "正常" Then

        ElseIf ActiveSheet.Range("X2").Value = "異常" Then
            If flagHantei <> 2 Then
                flagHantei = 1
            End If
        ElseIf ActiveSheet.Range("X2").Value = "不合格品" Then
            flagHantei = 2
        End If
    End If

    Dim mainHantei As Long
    If Worksheets("工程検査結果").Range("Y3").Value = "正常" Then
        mainHantei = 0
    ElseIf Worksheets("工程検査結果").Range("Y3").Value = "異常" Then
        mainHantei = 1
    ElseIf Worksheets("工程検査結果").Range("Y3").Value = "不合格品" Then
        mainHantei = 2
    End If

    If mainHantei <> flagHantei Then
        MsgBox "工程検査結果シートの判断が各規格シートの判断と違います。" & vbCrLf & "判断をそろえてください。"
        Exit Sub
    End If

    ''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    '検査状況を異常、不合格品のときは、DBに登録するスクリプト'
    '                                                        '
    ''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    Worksheets("単重").Activate
    If ActiveSheet.Range("X2").Value = "異常" Then
        Set Rs = New ADODB.Recordset        ' RecordSetオブジェクトの初期化
        values = " values (" & checkKouteiId & ",0,1,'" & Now & "')" 'size_numは、単重のときは[0]。statusは、異常のときは、[1]
        insertString = "INSERT INTO result_check_koutei (check_koutei_id,size_num,status,update_datetime) " & values
        Set Rs = Cn.Execute(insertString)
    ElseIf ActiveSheet.Range("X2").Value = "不合格品" Then
        values = " values (" & checkKouteiId & ",0,2,'" & Now & "')" 'size_numは、単重のときは[0]。statusは、不合格品のときは、[2]
        insertString = "INSERT INTO result_check_koutei (check_koutei_id,size_num,status,update_datetime) " & values
        Set Rs = Cn.Execute(insertString)
    End If

    kikakuGyo = 5 '5行目が規格名
    startCol = 8  '8列目が始まりの列
    kikakuCol = startCol
    Dim size_num As Long
    Do While Worksheets("工程検査結果").Cells(kikakuGyo, kikakuCol).Value <> ""
        size_num = Worksheets("工程検査結果").Cells(kikakuGyo, kikakuCol).Value
        Worksheets("規格" & size_num).Activate

            If ActiveSheet.Range("X2").Value = "異常" Then
                Set Rs = New ADODB.Recordset        ' RecordSetオブジェクトの初期化
                values = " values (" & checkKouteiId & "," & size_num & ",1,'" & Now & "')" 'statusは、異常のときは、[1]
                insertString = "INSERT INTO result_check_koutei (check_koutei_id,size_num,status,update_datetime) " & values
                Set Rs = Cn.Execute(insertString)
            ElseIf ActiveSheet.Range("X2").Value = "不合格品" Then
                 values = " values (" & checkKouteiId & "," & size_num & ",2,'" & Now & "')" 'statusは、不合格品のときは、[2]
                insertString = "INSERT INTO result_check_koutei (check_koutei_id,size_num,status,update_datetime) " & values
                Set Rs = Cn.Execute(insertString)
            End If

        kikakuCol = kikakuCol + 1

    Loop

    Worksheets("工程検査結果").Activate

    Set Rs = New ADODB.Recordset        ' RecordSetオブジェクトの初期化
    updateCheckKouteiString = "UPDATE check_koutei set status = " & mainHantei & ",update_datetime = '" & Now & "'  where product_id = '" & product_id & "' and lot_num = '" & lot_num & "'"
    Set Rs = Cn.Execute(updateCheckKouteiString)

    Cells(endRow, 7).Value = Range("Y3").Value
    Range("Y3").ClearContents

    ActiveWorkbook.Save
Err_proc:
        If (Err.Number <> 0) Then
            Call MsgBox(Err.Description)
            Call MsgBox("レコードの読み込みでエラーが発生しました｡")
        End If

        Set Rs = Nothing

       If P_CheckDatabase() Then   ' データベースに接続している？
            Status = P_CloseDatabase    ' データベースへの接続の解除
            If Status = 0 Then
                Range("A1").Font.Color = RGB(0, 0, 255)     ' 青色で文字列表示
                Range("A1").Value = "データベース未接続"
            End If
        Else
            Beep
        End If
End Sub

Private Sub checkKoutei_Click()

    Dim startRow As Long
    Dim endRow As Long
    Dim endCol As Long
    Dim baseRow As Long
    Dim widthGraph As Long
    Dim ratioWidth As Long
    Dim heightGraph As Long

    Dim kikakuGyo As Long
    Dim kikakuCol As Long
    Dim startCol As Long
    Dim numKikaku As Long
    Dim numTorisu As Long
    Dim sh As Shape
    Dim activeEndRow As Long
    Dim alf As String

    kikakuGyo = 5 '5行目が規格名
    startCol = 8  '8列目が始まりの列

    '規格数の取得
    kikakuCol = startCol
    numKikaku = 0

    'startRowの取得
    If Range("T2").Value = "" Then
        If Range("H65536").End(xlUp).Row - 200 >= 200 Then '最終データから100までをグラフに
            startRow = Range("H65536").End(xlUp).Row - 200
        Else
            startRow = 11 '最終データまでの総数が、100まで揃ってない場合
        End If
    Else
        If Range("T2").Value < 11 Then
            startRow = 11
        Else
            startRow = Range("T2").Value
        End If
    End If

    'endRowの取得
    If Range("T3").Value = "" Then
        endRow = Range("H65536").End(xlUp).Row
    Else
        endRow = Range("T3").Value

    End If

    If endRow - startRow <= 0 Then
        MsgBox "開始行と終了行に矛盾があります。"
        Exit Sub
    ElseIf endRow - startRow = 201 Then
        widthGraph = 1500
    ElseIf endRow - startRow < 100 Then
        widthGraph = 1250
    ElseIf endRow - startRow > 201 Or endRow - startRow < 201 Then
        ratioWidth = (endRow - startRow) / 201
        widthGraph = 1500 * ratioWidth
    End If

    '空欄チェック
    endCol = Range("G9").End(xlToRight).Column '最終列取得
    If Cells(endRow, 1).Value = "" Then
        MsgBox "担当者が空欄です。"
        Exit Sub
    Else
        Dim numCol As Long
        For numCol = 4 To 6
            If Cells(endRow, numCol).Value = "" Then
                MsgBox "日付、時間、ロットNO.欄のどれかに空欄があります。"
                Exit Sub
            End If
        Next numCol

        For numCol = 8 To endCol
            If Cells(endRow, numCol).Value = "" Then
                MsgBox "検査結果欄に空欄があります。"
                Exit Sub
            End If
        Next numCol
    End If

    heightGraph = 300

    Worksheets("単重").Activate
    ActiveSheet.Columns("X").Delete
    For Each sh In ActiveSheet.Shapes  '---アクティブシート全ての図形に対し
        sh.Delete       'shapes削除
    Next sh
    activeEndRow = ActiveSheet.Range("A65536").End(xlUp).Row
    alf = checkAlfabet(ActiveSheet.Cells(1, Columns.Count).End(xlToLeft).Column) '列のアルファベット取得
    ActiveSheet.Range("A1:" & alf & activeEndRow).Clear
    Worksheets("工程検査結果").Range(Cells(startRow, 4), Cells(endRow, 5)).Copy Worksheets("単重").Cells(1, 1)

    Do While Cells(kikakuGyo, kikakuCol).Value <> ""


        Worksheets("規格" & Cells(kikakuGyo, kikakuCol).Value).Activate
        ActiveSheet.Columns("X").Delete
        For Each sh In ActiveSheet.Shapes  '---アクティブシート全ての図形に対し
            sh.Delete       'shapes削除
        Next sh

        activeEndRow = ActiveSheet.Range("A65536").End(xlUp).Row
        alf = checkAlfabet(ActiveSheet.Cells(1, Columns.Count).End(xlToLeft).Column) '列のアルファベット取得

        ActiveSheet.Range("A1:" & alf & activeEndRow).Clear


        Worksheets("工程検査結果").Range(Cells(startRow, 4), Cells(endRow, 5)).Copy Worksheets("規格" & Cells(kikakuGyo, kikakuCol).Value).Cells(1, 1)

        numKikaku = numKikaku + 1
        kikakuCol = kikakuCol + 1

    Loop

    Worksheets("工程検査結果").Activate

    '取数の取得
    Dim offsetKikakuCol As Long
    offsetKikakuCol = numKikaku + 2 '規格数+外観+単重
    numTorisu = 0
    kikakuCol = startCol
    Do While Cells(kikakuGyo, kikakuCol).Value <> ""

        numTorisu = numTorisu + 1
        kikakuCol = kikakuCol + offsetKikakuCol

    Loop

    '各シートに測定データをコピー
    Dim i As Long
    Dim j As Long
    Dim k As Long

    kikakuCol = startCol
    For i = 1 To numKikaku + 1 '規格単位ループ

        For j = 1 To numTorisu + 1 '型番単位ループ
            If i <> numKikaku + 1 Then
                If j <= numTorisu Then

                    Worksheets("工程検査結果").Range(Cells(startRow, kikakuCol), Cells(endRow, kikakuCol)).Copy Worksheets("規格" & Cells(kikakuGyo, kikakuCol).Value).Cells(1, 2 + j)

                ElseIf j = numTorisu + 1 Then
                    For k = 1 To endRow - startRow + 1 '規格値をグラフに表現する
                        Worksheets("規格" & Cells(kikakuGyo, kikakuCol - offsetKikakuCol).Value).Cells(k, 2 + j).Value = Worksheets("工程検査結果").Cells(8, kikakuCol - offsetKikakuCol).Value + Worksheets("工程検査結果").Cells(7, kikakuCol - offsetKikakuCol).Value
                        Worksheets("規格" & Cells(kikakuGyo, kikakuCol - offsetKikakuCol).Value).Cells(k, 2 + j + 1).Value = Worksheets("工程検査結果").Cells(8, kikakuCol - offsetKikakuCol).Value + Worksheets("工程検査結果").Cells(6, kikakuCol - offsetKikakuCol).Value

                    Next k
                End If


                Worksheets("規格" & i).Activate
            Else '単重シート

                Worksheets("単重").Activate

                If j <= numTorisu Then

                    Worksheets("工程検査結果").Range(Cells(startRow, kikakuCol + 1), Cells(endRow, kikakuCol + 1)).Copy Worksheets("単重").Cells(1, 2 + j)

                ElseIf j = numTorisu + 1 Then

                    activeEndRow = ActiveSheet.Range("A65536").End(xlUp).Row
                    alf = checkAlfabet(ActiveSheet.Cells(1, Columns.Count).End(xlToLeft).Column) '列のアルファベット取得
                    For k = 1 To endRow - startRow + 1 '規格値をグラフに表現する

                        Worksheets("単重").Cells(k, 2 + j).Value = Application.WorksheetFunction.Min(ActiveSheet.Range("C1:" & alf & activeEndRow))
                        Worksheets("単重").Cells(k, 2 + j + 1).Value = Application.WorksheetFunction.Max(ActiveSheet.Range("C1:" & alf & activeEndRow))

                    Next k
                End If
            End If
            kikakuCol = kikakuCol + offsetKikakuCol
        Next j


            kikakuCol = kikakuCol - offsetKikakuCol * 2
            'グラフ挿入

            ActiveSheet.Shapes.AddChart.Select
            ActiveChart.ChartType = xlLineMarkers

            For Each sh In ActiveSheet.Shapes  '---アクティブシート全ての図形に対し
                sh.Top = Range("B5").Top       '---上端位置をB2の上端へ
                sh.Left = Range("B5").Left     '---左端位置をB2の左端へ
                sh.Width = widthGraph
                sh.Height = heightGraph
            Next sh

            activeEndRow = ActiveSheet.Range("A65536").End(xlUp).Row
            alf = checkAlfabet(ActiveSheet.Cells(1, Columns.Count).End(xlToLeft).Column) '列のアルファベット取得

            If i <> numKikaku + 1 Then 'Y軸の最大、最少目盛を設定
                ActiveChart.Axes(xlValue, xlPrimary).MinimumScale = Worksheets("工程検査結果").Cells(8, kikakuCol).Value + Worksheets("工程検査結果").Cells(7, kikakuCol).Value
                ActiveChart.Axes(xlValue, xlPrimary).MaximumScale = Worksheets("工程検査結果").Cells(8, kikakuCol).Value + Worksheets("工程検査結果").Cells(6, kikakuCol).Value
                ActiveChart.SetSourceData Source:=ActiveSheet.Range("A1:B" & activeEndRow & ",C1:" & alf & activeEndRow)

            Else
                activeEndRow = ActiveSheet.Range("A65536").End(xlUp).Row
                alf = checkAlfabet(ActiveSheet.Cells(1, Columns.Count).End(xlToLeft).Column) '列のアルファベット取得
                ActiveChart.Axes(xlValue, xlPrimary).MinimumScale = Application.WorksheetFunction.Min(ActiveSheet.Range("C1:" & alf & activeEndRow))
                ActiveChart.Axes(xlValue, xlPrimary).MaximumScale = Application.WorksheetFunction.Max(ActiveSheet.Range("C1:" & alf & activeEndRow))
                ActiveChart.Axes(xlValue, xlPrimary).TickLabels.NumberFormatLocal = "G/標準"
                ActiveChart.SetSourceData Source:=ActiveSheet.Range("A1:B" & activeEndRow & ",C1:" & alf & activeEndRow)


            End If
            Worksheets("工程検査結果").Range("Y2:Y3").Copy ActiveSheet.Range("X1")  '工程検査結果シートから分布状況リストを各シートに追加していく
            kikakuCol = startCol + i
    Next i

    Worksheets("工程検査結果").Activate


    ' データベースへの接続を確認
    Dim Status As Long
    If P_CheckDatabase() = False Then    ' データベースに接続していない？
        Status = P_OpenDatabase  ' データベースへ接続
        If Status = 0 Then
            Range("A1").Font.Color = RGB(255, 0, 0)     ' 赤色で文字列表示
            Range("A1").Value = "データベース接続中"
        Else
            Range("A1").Font.Color = RGB(255, 0, 0)     ' 赤色で文字列表示
            Range("A1").Value = "データベース接続エラー"
            Exit Sub
        End If
    End If
    Set Rs = New ADODB.Recordset        ' RecordSetオブジェクトの初期化
    Dim product_id As String
    product_id = Range("G2").Value
    Dim lot_num As String
    lot_num = Cells(endRow, 6).Value
    Dim emp As String
    emp = Cells(endRow, 1).Value
    Dim values As String
    values = " values ('" & product_id & "','" & lot_num & "','" & emp & "','" & Now & "')"
    Dim insertCheckKoutei As String
    insertCheckKoutei = "INSERT INTO check_koutei (product_id,lot_num,emp,datetime_graph) " & values
    If Range("T2").Value = "" Or Range("T3").Value = "" Then
        Set Rs = Cn.Execute(insertCheckKoutei)
    End If

    Range("T2:U2").ClearContents
    Range("T3:U3").ClearContents

    ActiveWorkbook.Save
Err_proc:
        If (Err.Number <> 0) Then
            Call MsgBox(Err.Description)
            Call MsgBox("レコードの読み込みでエラーが発生しました｡")
        End If

        Set Rs = Nothing

       If P_CheckDatabase() Then   ' データベースに接続している？
            Status = P_CloseDatabase    ' データベースへの接続の解除
            If Status = 0 Then
                Range("A1").Font.Color = RGB(0, 0, 255)     ' 青色で文字列表示
                Range("A1").Value = "データベース未接続"
            End If
        Else
            Beep
        End If

End Sub

Private Sub ImDataButton_Click()
If Range("h9").Value <> "" Then

    Dim kikaku_GYO As Long
    Dim kikaku_COL As Long
    Dim i As Long
    Dim h As Long
    Dim offset As Long

    Dim im_size_num As Long
    Dim kind_kensa As String

    Dim ImSizeNumYobidashi As String
    Dim ImResultYobidashi As String

    Dim Raw As Long
    Dim lot_num As String

    Dim maxCol As Long

    Raw = Range("F65536").End(xlUp).Row
    maxCol = Range("FV11").End(xlToLeft).Column ' IV1=256列

    If maxCol >= 11 Then

        Range(Cells(Raw, 8), Cells(Raw, maxCol)).ClearContents

    End If


    Worksheets("検査結果仮置").Range("A1:Z100").ClearContents

    ' データベースへの接続を確認
            If P_CheckDatabase() = False Then    ' データベースに接続していない？
                Status = P_OpenDatabase  ' データベースへ接続
                If Status = 0 Then
                    Range("A1").Font.Color = RGB(255, 0, 0)     ' 赤色で文字列表示
                    Range("A1").Value = "データベース接続中"
                Else
                    Range("A1").Font.Color = RGB(255, 0, 0)     ' 赤色で文字列表示
                    Range("A1").Value = "データベース接続エラー"
                    Exit Sub
                End If
            End If

    product_id = Range("G2").Value

    Set Rs = New ADODB.Recordset        ' RecordSetオブジェクトの初期化
    torisuYobidashi = "SELECT torisu FROM katakouzou where product_id = '" & product_id & "'"
    Set Rs = Cn.Execute(torisuYobidashi)
    torisu = Rs.Fields(0).Value

    If torisu = 1 Then

        num_kensa = 5

    ElseIf torisu = 2 Then

        num_kensa = 4

    Else

        num_kensa = torisu

    End If

    kikaku_GYO = 6
    kikaku_COL = 8
    Do While Cells(kikaku_GYO, kikaku_COL).Value <> ""

        kikaku_COL = kikaku_COL + 1

    Loop

    kikaku_COL = kikaku_COL - 8


    lot_num = Range("F" & Raw).Value

    offset = 1
    For i = 1 To kikaku_COL
        Set Rs = New ADODB.Recordset        ' RecordSetオブジェクトの初期化
        ImSizeNumYobidashi = "SELECT im_size_num,kind_kensa FROM koutei_im_kikaku_taiou where product_id = '" & product_id & "' and kensahyou_size = " & i
        Set Rs = Cn.Execute(ImSizeNumYobidashi)

        If Rs.EOF = False Then

            im_size_num = Rs.Fields(0).Value
            kind_kensa = Rs.Fields(1).Value

            Set Rs_result = New ADODB.Recordset
            ImResultYobidashi = "select result from koutei_im_sokuteidata_result as a inner join koutei_im_sokuteidata_head as b on a.id=b.id " & _
                                "where b.product_id = '" & product_id & "' and b.kind_kensa = '" & product_id & "_" & kind_kensa & "' and b.lot_num = '" & lot_num & "' and a.size_num = " & im_size_num
            Set Rs_result = Cn.Execute(ImResultYobidashi)

            Worksheets("検査結果仮置").Cells(1, i).CopyFromRecordset Rs_result


            For h = 1 To num_kensa

                Cells(Raw, 8 + offset - 1).Value = Application.WorksheetFunction.Round(Worksheets("検査結果仮置").Cells(h, i).Value, 2)
                offset = offset + kikaku_COL + 2

            Next


        End If
        offset = i + 1

    Next

    maxCol = Range("FV9").End(xlToLeft).Column ' IV1=256列
    For i = 1 To maxCol

        With Range(Cells(Raw + 1, 1), Cells(Raw + 1, i))
            .Borders(xlEdgeTop).LineStyle = xlContinuous
        '       .Borders(xlEdgeTop).Weight = xlMedium
            .Borders(xlEdgeBottom).LineStyle = xlContinuous
        '       .Borders(xlEdgeBottom).Weight = xlMedium
            .Borders(xlEdgeLeft).LineStyle = xlContinuous
        '                    .Borders(xlEdgeLeft).Weight = xlMedium
            .Borders(xlEdgeRight).LineStyle = xlContinuous
        '                    .Borders(xlEdgeRight).Weight = xlMedium
        End With

    Next

End If

Err_proc:
        If (Err.Number <> 0) Then
            Call MsgBox(Err.Description)
            Call MsgBox("レコードの読み込みでエラーが発生しました｡")
        End If

        Set Rs = Nothing

       If P_CheckDatabase() Then   ' データベースに接続している？
            Status = P_CloseDatabase    ' データベースへの接続の解除
            If Status = 0 Then
                Range("A1").Font.Color = RGB(0, 0, 255)     ' 青色で文字列表示
                Range("A1").Value = "データベース未接続"
            End If
        Else
            Beep
        End If

End Sub

Private Sub KensaHeadButton_Click()
If Range("G2").Value <> "" Then

    Dim kikaku_GYO As Long
    Dim kikaku_COL As Long
    Dim kataban_GYO As Long
    Dim kataban_COL As Long
    Dim torisuYobidashi As String
    Dim headerYobidashi As String
    Dim kindYobidashi As String

    Dim product_id As String
    Dim torisu As Long
    Dim num_kensa As Long
    Dim kikaku_num As Long

    Dim i As Long
    Dim h As Long

    Dim maxCol As Long

    maxCol = Range("FV9").End(xlToLeft).Column ' IV1=256列
    If maxCol >= 8 Then

        Range(Cells(5, 8), Cells(9, maxCol)).ClearContents

    End If


    ' データベースへの接続を確認
            If P_CheckDatabase() = False Then    ' データベースに接続していない？
                Status = P_OpenDatabase  ' データベースへ接続
                If Status = 0 Then
                    Range("A1").Font.Color = RGB(255, 0, 0)     ' 赤色で文字列表示
                    Range("A1").Value = "データベース接続中"
                Else
                    Range("A1").Font.Color = RGB(255, 0, 0)     ' 赤色で文字列表示
                    Range("A1").Value = "データベース接続エラー"
                    Exit Sub
                End If
            End If

    product_id = Range("G2").Value

    '取り数に応じて製品検査数の確定
    Set Rs = New ADODB.Recordset        ' RecordSetオブジェクトの初期化
    torisuYobidashi = "SELECT a.torisu,b.product_name FROM katakouzou as a inner join product b on a.product_id=b.product_id where a.product_id = '" & product_id & "' order by a.kataban desc"
    Set Rs = Cn.Execute(torisuYobidashi)

    If Rs.EOF = False Then

        torisu = Rs.Fields(0).Value
        Range("G3:I3").Value = Rs.Fields(1).Value

        If torisu = 1 Then

            num_kensa = 5

        ElseIf torisu = 2 Then

            num_kensa = 4

        Else

            num_kensa = torisu

        End If

    End If

    Set Rs = New ADODB.Recordset        ' RecordSetオブジェクトの初期化

    headerYobidashi = "SELECT " & _
                      "size_1,upper_1,lower_1," & _
                      "size_2,upper_2,lower_2," & _
                      "size_3,upper_3,lower_3," & _
                      "size_4,upper_4,lower_4," & _
                      "size_5,upper_5,lower_5," & _
                      "size_6,upper_6,lower_6," & _
                      "size_7,upper_7,lower_7," & _
                      "size_8,upper_8,lower_8," & _
                      "size_9,text_10,text_11,bik " & _
                      " FROM koutei_kensahyou_head WHERE product_id = '" & product_id & "'"

    Set Rs = Cn.Execute(headerYobidashi)

    kikaku_GYO = 8
    kikaku_COL = 8
    kataban_GYO = 10
    kataban_COL = kikaku_COL

            ' レコードがあるときだけワークシートに転送
            If Rs.EOF = False Then

                Do While Rs.EOF = False

                  For i = 1 To num_kensa '製品検査数だけループする

                    For h = 0 To 24 'kensahyou_headにはsize_1,upper_1,lower_1からsize_8,upper_8,lower_8まであるので、3×8=24

                        If IsNull(Rs.Fields(h)) = False Then 'kikaku_numは規格番号を示す。hは、３つ飛ばし。

                            Cells(kikaku_GYO, kikaku_COL).Value = Application.WorksheetFunction.Round(Rs.Fields(h), 2) '規格値をセルに挿入

                            If h = 0 Then
                                kikaku_num = 1
                            ElseIf h = 3 Then
                                kikaku_num = 2
                            ElseIf h = 6 Then
                                kikaku_num = 3
                            ElseIf h = 9 Then
                                kikaku_num = 4
                            ElseIf h = 12 Then
                                kikaku_num = 5
                            ElseIf h = 15 Then
                                kikaku_num = 6
                            ElseIf h = 18 Then
                                kikaku_num = 7
                            ElseIf h = 12 Then
                                kikaku_num = 8
                            ElseIf h = 24 Then 'h=24になるときは、size_9が存在するとき
                                kikaku_num = kikaku_num + 1
                            End If

                            Set Rs_kind = New ADODB.Recordset
                            kindYobidashi = "select kind_kensa from koutei_im_kikaku_taiou " & _
                                            "where product_id = '" & product_id & "' and kensahyou_size =" & kikaku_num
                            Set Rs_kind = Cn.Execute(kindYobidashi)

                            If h <> 24 Then
                                If Rs_kind.EOF <> False Then

                                   Cells(9, kikaku_COL).Value = "ノギス"

                                Else

                                   Cells(9, kikaku_COL).Value = Rs_kind.Fields(0)

                                End If
                            Else
                                   Cells(9, kikaku_COL).Value = "フレ"
                            End If

                            If h <> 24 Then
                                h = h + 1
                                Cells(kikaku_GYO - 2, kikaku_COL).Value = Application.WorksheetFunction.Round(Rs.Fields(h), 2) '上限値をセルに挿入
                                h = h + 1
                                Cells(kikaku_GYO - 1, kikaku_COL).Value = Application.WorksheetFunction.Round(Rs.Fields(h), 2) '下限値をセルに挿入
                                Cells(kikaku_GYO - 3, kikaku_COL).Value = kikaku_num
                                kikaku_COL = kikaku_COL + 1
                            Else 'フレ値の時
                                Cells(kikaku_GYO - 2, kikaku_COL).Value = 0 '上限値をセルに挿入
                                Cells(kikaku_GYO - 1, kikaku_COL).Value = Application.WorksheetFunction.Round(Rs.Fields(h), 2) * -1 '下限値をセルに挿入
                                Cells(kikaku_GYO - 3, kikaku_COL).Value = kikaku_num
                                kikaku_COL = kikaku_COL + 1
                            End If

                        End If

                    Next
                    Cells(9, kikaku_COL).Value = "外観"
                    kikaku_COL = kikaku_COL + 1
                    Cells(9, kikaku_COL).Value = "単重"
                    With Range(Cells(kataban_GYO, kataban_COL), Cells(kataban_GYO, kikaku_COL))
                        .MergeCells = True
                        .Value = i
                        .HorizontalAlignment = xlCenter
                        .Interior.ColorIndex = 16
                        .Font.ColorIndex = 2
                        .Font.Bold = True
                        .Borders(xlEdgeTop).LineStyle = xlContinuous
                        .Borders(xlEdgeTop).Weight = xlMedium
                        .Borders(xlEdgeBottom).LineStyle = xlContinuous
                        .Borders(xlEdgeBottom).Weight = xlMedium
                        .Borders(xlEdgeLeft).LineStyle = xlContinuous
                        .Borders(xlEdgeLeft).Weight = xlMedium
                        .Borders(xlEdgeRight).LineStyle = xlContinuous
                        .Borders(xlEdgeRight).Weight = xlMedium
                    End With

                    kikaku_COL = kikaku_COL + 1
                    kataban_COL = kikaku_COL
                  Next

                  Rs.MoveNext

                Loop

            Else

            End If

    maxCol = Range("FV9").End(xlToLeft).Column ' IV1=256列
    For k = 5 To 9

        For i = 7 To maxCol
            With Range(Cells(k, 7), Cells(k, i))
                .Borders(xlEdgeTop).LineStyle = xlContinuous
                .Borders(xlEdgeTop).Weight = xlMedium
                .Borders(xlEdgeBottom).LineStyle = xlContinuous
            '       .Borders(xlEdgeBottom).Weight = xlMedium
                .Borders(xlEdgeLeft).LineStyle = xlContinuous
            '                    .Borders(xlEdgeLeft).Weight = xlMedium
                .Borders(xlEdgeRight).LineStyle = xlContinuous
            '                    .Borders(xlEdgeRight).Weight = xlMedium
            End With

        Next

    Next

    For i = 1 To maxCol

            With Range(Cells(11, 1), Cells(11, i))
                .Borders(xlEdgeTop).LineStyle = xlContinuous
                .Borders(xlEdgeTop).Weight = xlMedium
                .Borders(xlEdgeBottom).LineStyle = xlContinuous
            '       .Borders(xlEdgeBottom).Weight = xlMedium
                .Borders(xlEdgeLeft).LineStyle = xlContinuous
            '                    .Borders(xlEdgeLeft).Weight = xlMedium
                .Borders(xlEdgeRight).LineStyle = xlContinuous
            '                    .Borders(xlEdgeRight).Weight = xlMedium
            End With

    Next
    ''''''''''''''''''''''
    '''グラフシート作成'''
    ''                 '''
    ''''''''''''''''''''''
    Dim mySheet As Worksheet
    Dim checkSheet As Long

    checkSheet = 0

    For Each mySheet In Worksheets      '---(1)

        If mySheet.Name = "単重" Then
            checkSheet = 1
        End If
    Next

    If checkSheet = 0 Then 'シートが作成されていない場合のみ

        Dim startRow As Long
        Dim endRow As Long
        Dim kikakuGyo As Long
        Dim kikakuCol As Long
        Dim startCol As Long
        Dim numKikaku As Long
        Dim numTorisu As Long

        kikakuGyo = 5 '5行目が規格名
        startCol = 8  '8列目が始まりの列

        '規格数の取得
        kikakuCol = startCol
        numKikaku = 0
        Do While Cells(kikakuGyo, kikakuCol).Value <> ""

            With Worksheets.Add()
                .Name = "規格" & Cells(kikakuGyo, kikakuCol).Value
            End With

            numKikaku = numKikaku + 1
            kikakuCol = kikakuCol + 1

        Loop

            With Worksheets.Add()
                .Name = "単重"
            End With

        Worksheets("工程検査結果").Activate

        '''''''''''''''''''''''''''''''''''
        '''''''''''''''''''''''''''''''''''
        '''''''''''''''''''''''''''''''''''

    End If
Err_proc:
            If (Err.Number <> 0) Then
                Call MsgBox(Err.Description)
                Call MsgBox("レコードの読み込みでエラーが発生しました｡")
            End If

            Set Rs = Nothing

           If P_CheckDatabase() Then   ' データベースに接続している？
                Status = P_CloseDatabase    ' データベースへの接続の解除
                If Status = 0 Then
                    Range("A1").Font.Color = RGB(0, 0, 255)     ' 青色で文字列表示
                    Range("A1").Value = "データベース未接続"
                End If
            Else
                Beep
            End If

End If

End Sub










Private Sub makeAnalyzeData_Click()

  '列名テンプレート
  Worksheets("分析データ").Range("A1").Value = "emp"
  Worksheets("分析データ").Range("B1").Value = "date"
  Worksheets("分析データ").Range("C1").Value = "time"
  Worksheets("分析データ").Range("D1").Value = "product_id"
  Worksheets("分析データ").Range("E1").Value = "lotNum"
  Worksheets("分析データ").Range("F1").Value = "standardNum"
  Worksheets("分析データ").Range("G1").Value = "standardSize"
  Worksheets("分析データ").Range("H1").Value = "standardUpper"
  Worksheets("分析データ").Range("I1").Value = "standardLower"
  Worksheets("分析データ").Range("J1").Value = "caviNum"
  Worksheets("分析データ").Range("K1").Value = "result"

  Dim i As Long
  Dim j As Long
  Dim k As Long
  Dim h As Long
  Dim m As Long


  Dim numCavi As Long
  Dim numStandard As Long
  Dim targetRow As Long
  Dim lastRow As Long
  Dim nextCaviCol As Long
  Dim maxCol As Long

  maxCol = Cells(10, Columns.Count).End(xlToLeft).Column '最終列取得
  numCavi = Cells(10, maxCol).Value

  maxCol = Cells(5, 8).End(xlToRight).Column
  numStandard = Cells(5, maxCol).Value '規格数取得

  targetRow = 11
  lastRow = Cells(Rows.Count, 6).End(xlUp).Row '最終行取得

  Dim targetDataRow As Long
  targetDataRow = Worksheets("分析データ").Cells(Rows.Count, 5).End(xlUp).Row + 1 '分析データシートの挿入行位置番号
  Dim resultLastLot As String
  resultLastLot = Worksheets("分析データ").Range("E" & targetDataRow - 1).Value

  '分析データ更新データ行探索
  For m = lastRow To 11 Step -1

        If Range("F" & m).Value = resultLastLot Then

            targetRow = m + 1
            Exit For

        End If

  Next m




  Dim targetStandardCol As Long
  targetStandardCol = 8

  For j = targetRow To lastRow

    For i = 1 To numCavi
        '次キャビNO.の始まり列取得
        If i <> numCavi Then

            nextCaviCol = maxCol + 1
            Do While Cells(5, nextCaviCol).Value = ""
             nextCaviCol = nextCaviCol + 1
            Loop

        Else

            nextCaviCol = Cells(9, Columns.Count).End(xlToLeft).Column

        End If

        For k = 1 To numStandard
            Worksheets("分析データ").Range("A" & targetDataRow).Value = Range("A" & j).Value '担当者
            Worksheets("分析データ").Range("B" & targetDataRow).Value = Range("D" & j).Value '日付
            Worksheets("分析データ").Range("C" & targetDataRow).Value = Range("E" & j).Value '時間
            Worksheets("分析データ").Range("D" & targetDataRow).Value = Range("G2").Value '品番
            Worksheets("分析データ").Range("E" & targetDataRow).Value = Range("F" & j).Value 'ロット
            Worksheets("分析データ").Range("F" & targetDataRow).Value = k '規格NO.
            Worksheets("分析データ").Range("G" & targetDataRow).Value = Cells(8, targetStandardCol).Value '規格値
            Worksheets("分析データ").Range("H" & targetDataRow).Value = Cells(6, targetStandardCol).Value + Cells(8, targetStandardCol).Value '上限値"
            Worksheets("分析データ").Range("I" & targetDataRow).Value = Cells(7, targetStandardCol).Value + Cells(8, targetStandardCol).Value '下限値"
            Worksheets("分析データ").Range("J" & targetDataRow).Value = i '型番"
            Worksheets("分析データ").Range("K" & targetDataRow).Value = Cells(j, targetStandardCol).Value '測定値"

            targetDataRow = targetDataRow + 1
            targetStandardCol = targetStandardCol + 1
        Next k

        '単重データを分析データシートに移行
            Worksheets("分析データ").Range("A" & targetDataRow).Value = Range("A" & j).Value '担当者
            Worksheets("分析データ").Range("B" & targetDataRow).Value = Range("D" & j).Value '日付
            Worksheets("分析データ").Range("C" & targetDataRow).Value = Range("E" & j).Value '時間
            Worksheets("分析データ").Range("D" & targetDataRow).Value = Range("G2").Value '品番
            Worksheets("分析データ").Range("E" & targetDataRow).Value = Range("F" & j).Value 'ロット
            Worksheets("分析データ").Range("F" & targetDataRow).Value = "単重" '規格NO.
            Worksheets("分析データ").Range("G" & targetDataRow).Value = "" '規格値
            Worksheets("分析データ").Range("H" & targetDataRow).Value = "" '上限値"
            Worksheets("分析データ").Range("I" & targetDataRow).Value = "" '下限値"
            Worksheets("分析データ").Range("J" & targetDataRow).Value = i '型番"
            If i <> numCavi Then
                Worksheets("分析データ").Range("K" & targetDataRow).Value = Cells(j, nextCaviCol - 1).Value '測定値"
            Else
                Worksheets("分析データ").Range("K" & targetDataRow).Value = Cells(j, nextCaviCol).Value  '測定値"
            End If

            targetDataRow = targetDataRow + 1
            targetStandardCol = nextCaviCol

            maxCol = Cells(5, nextCaviCol).End(xlToRight).Column '次キャビの規格最終列取得

    Next i

    maxCol = Cells(5, 8).End(xlToRight).Column
    targetStandardCol = 8
  Next j

    'Range("A2").Value = resultLastLot

End Sub
