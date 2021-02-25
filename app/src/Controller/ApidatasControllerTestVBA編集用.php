Function rironZaikoTouroku(targetDay, sLastDay)

Dim strDateRironStock As String
strDateRironStock = Range("A2").Value & "-" & Range("C2").Value & "-" & targetDay
Dim intTargetDay As Integer
intTargetDay = targetDay
Dim strTargetDate As String
strTargetDate = Range("A2").Value & "-" & Range("C2").Value & "-" & intTargetDay + 1 'プログラム内使用実績無し

Call rironZaikoTourokus(strDateRironStock, intTargetDay, strTargetDate, sLastDay)

End Function
Function rironZaikoTourokus(strDateRironStock, intTargetDay, strTargetDate, Date_tyousei)
Dim i As Integer
Dim k As Integer
Dim m As Integer
Dim n As Integer
Dim o As Integer
Dim p As Integer
Dim q As Integer

Dim amount As Long

Dim ShFm1 As Worksheet
Dim lnFm1 As Long
Dim lnFm1Mx As Long
Dim ShFm2 As Worksheet
Dim lnFm2 As Long
Dim lnFm2Mx As Long
Dim mae_hinban As String
Dim getsumatsu_hinban As String
Dim dd As Integer
Dim Name As String



Dim kariokiAmount As Long

Dim http As New XMLHTTP60
Dim url As String

Application.StatusBar = "処理中…"




'最終行取得
Set ShFm1 = Worksheets("OrderEdis")
lnFm1Mx = ShFm1.Range("c65536").End(xlUp).Row

Set ShFm2 = Worksheets("StockProducts")
lnFm2Mx = ShFm2.Range("a65536").End(xlUp).Row



i = 0
k = 0
n = 1
o = 0
p = 1
q = 1
r = 1
mae_hinban = ""
'納入数・伝票枚数・月末在庫編集
For lnFm1 = 1 To lnFm1Mx
    '読み込んだレコードと格納した品番をチェック
    If ShFm1.Range("C" & lnFm1).Value <> mae_hinban Then
      '入庫数・組立（入庫数）・所要計画数編集
      If mae_hinban <> "" Then

        '在庫数編集

        kariokiAmount = Zaikosu_hensyu(k, Date_tyousei, intTargetDay)

        If i = 0 Then

            url = "http://localhost:5000/Apirironzaikos/tourokuzaiko/api/start.xml"
            With http
                .Open "PUT", url, False
                .setRequestHeader "Content-Type", "text/xml"
                .setRequestHeader "Pragma", "no-cache"
                .setRequestHeader "Cache-Control", "no-cache"
                .setRequestHeader "If-Modified-Since", "Thu, 01 Jun 1970 00:00:00 GMT"
                .send
            End With

        End If

        i = i + 1

        url = "http://localhost:5000/Apirironzaikos/tourokuzaiko/api/" & strDateRironStock & "_" & mae_hinban & "_" & kariokiAmount & ".xml"
        With http
            .Open "PUT", url, False
            .setRequestHeader "Content-Type", "text/xml"
            .setRequestHeader "Pragma", "no-cache"
            .setRequestHeader "Cache-Control", "no-cache"
            .setRequestHeader "If-Modified-Since", "Thu, 01 Jun 1970 00:00:00 GMT"
            .send
        End With


      Else

      End If

      '2製品目以降、行カウンタ5行加算
      If o > 0 Then
        k = k + 5
      Else

      End If

      Cells(9 + k, 1).Value = ShFm1.Range("C" & lnFm1).Value '品番の転送

      mae_hinban = ShFm1.Range("C" & lnFm1).Value '品番の転送

      o = o + 1

    Else

    End If
Next lnFm1

'在庫数編集
kariokiAmount = Zaikosu_hensyu(k, Date_tyousei, intTargetDay)

If i = 0 Then

    url = "http://localhost:5000/Apirironzaikos/tourokuzaiko/api/start.xml"
    With http
        .Open "PUT", url, False
        .setRequestHeader "Content-Type", "text/xml"
        .setRequestHeader "Pragma", "no-cache"
        .setRequestHeader "Cache-Control", "no-cache"
        .setRequestHeader "If-Modified-Since", "Thu, 01 Jun 1970 00:00:00 GMT"
        .send
    End With

End If
i = i + 1

url = "http://localhost:5000/Apirironzaikos/tourokuzaiko/api/" & strDateRironStock & "_" & mae_hinban & "_" & kariokiAmount & ".xml"
With http
    .Open "PUT", url, False
    .setRequestHeader "Content-Type", "text/xml"
    .setRequestHeader "Pragma", "no-cache"
    .setRequestHeader "Cache-Control", "no-cache"
    .setRequestHeader "If-Modified-Since", "Thu, 01 Jun 1970 00:00:00 GMT"
    .send
End With




If i > 0 Then

    url = "http://localhost:5000/Apirironzaikos/tourokuzaiko/api/end.xml"
    With http
        .Open "PUT", url, False
        .setRequestHeader "Content-Type", "text/xml"
        .setRequestHeader "Pragma", "no-cache"
        .setRequestHeader "Cache-Control", "no-cache"
        .setRequestHeader "If-Modified-Since", "Thu, 01 Jun 1970 00:00:00 GMT"
        .send
    End With

End If


Application.StatusBar = False

End Function
Function mainGessyoDate(Name)
Dim j As Integer
Dim i As Integer
Dim k As Integer
Dim m As Integer
Dim n As Integer
Dim o As Integer
Dim p As Integer
Dim q As Integer
Dim r As Integer
Dim Date_deliver As String
Dim amount As Long
'Dim next_date As String
Dim Date_tyousei As Integer
Dim Uruudoshi As Integer
Dim ShFm1 As Worksheet
Dim lnFm1 As Long
Dim lnFm1Mx As Long
Dim ShFm2 As Worksheet
Dim lnFm2 As Long
Dim lnFm2Mx As Long
Dim mae_hinban As String
Dim getsumatsu_hinban As String
Dim dd As Integer


Dim strDateRironStock As String
'strDateRironStock = Range("A2").Value & "-" & Range("C2").Value & "-16"

Dim strTargetDate As String
'strTargetDate = Range("A2").Value & "-" & Range("C2").Value & "-17"

Dim kariokiAmount As Long




Application.StatusBar = "処理中…"

Date_deliver = Range("A2").Value & "-" & Range("C2").Value & "-"

'If Range("C2").Value = 12 Then
'   next_date = Range("C2").Value + 1 & "-1-1" '成形生産数呼出時の月末日特定
'Else
'    next_date = Range("A2").Value & "-" & Range("C2").Value + 1 & "-1" '成形生産数呼出時の月末日特定
'End If

'各日にち毎計算
For j = 1 To 31

    Cells(8, j + 4).Value = j

Next j

Dim yyyy As Integer
Dim mm As Integer
yyyy = Range("A2").Value
mm = Range("C2").Value

'xmlデータ取込
Dim strUrl As String
strUrl = "http://localhost:5000/Apis/zaikocyou/api/" & yyyy & "-" & mm & "_" & Name & ".xml"
Load_gessyo_xml_torikomi (strUrl)

'最終行取得
Set ShFm1 = Worksheets("OrderEdis")
lnFm1Mx = ShFm1.Range("c65536").End(xlUp).Row

Set ShFm2 = Worksheets("StockProducts")
lnFm2Mx = ShFm2.Range("a65536").End(xlUp).Row

'月末日取得
If Range("D2").Value = 1 Or Range("C2").Value = 3 Or Range("C2").Value = 5 Or Range("C2").Value = 7 Or Range("C2").Value = 8 Or Range("C2").Value = 10 Or Range("C2").Value = 12 Then

   Date_tyousei = 31

ElseIf Range("C2").Value = 4 Or Range("C2").Value = 6 Or Range("C2").Value = 9 Or Range("C2").Value = 11 Then

   Date_tyousei = 30

ElseIf Range("C2").Value = 2 Then

   Uruudoshi = Range("C2").Value Mod 4

   If Uruudoshi = 0 Then

      Date_tyousei = 29

   Else

      Date_tyousei = 28

   End If

End If

i = 0
k = 0
n = 1
o = 0
p = 1
q = 1
r = 1
mae_hinban = ""
'納入数・伝票枚数・月末在庫編集
For lnFm1 = 1 To lnFm1Mx
    '読み込んだレコードと格納した品番をチェック
    If ShFm1.Range("C" & lnFm1).Value <> mae_hinban Then
      '入庫数・組立（入庫数）・所要計画数編集
      If mae_hinban <> "" Then
        '入庫数編集
        Call Nyukosu_hensyu(mae_hinban, p, k)
        '組立（入庫数）編集
        Call Kumitate_hensyu(mae_hinban, r, k)
        '所要計画数編集
        Call Syoyoukeikakusu_hensyu(mae_hinban, q, k)
        '在庫数編集

        kariokiAmount = Zaikosu_hensyu(k, Date_tyousei, 0)

      Else

      End If

      '2製品目以降、行カウンタ5行加算
      If o > 0 Then
        k = k + 5
      Else

      End If

      Cells(9 + k, 1).Value = ShFm1.Range("C" & lnFm1).Value '品番の転送

      mae_hinban = ShFm1.Range("C" & lnFm1).Value '品番の転送

      Cells(9 + k, 2).Value = ShFm1.Range("D" & lnFm1).Value '品名の転送
      Cells(9 + k, 4).Value = "納品数"
      Cells(10 + k, 4).Value = "入庫数"
      Cells(11 + k, 4).Value = "在庫数"
      Cells(12 + k, 4).Value = "所要計画"
      Cells(13 + k, 4).Value = "伝票枚数"

      '納品数セット
      If ShFm1.Range("G" & lnFm1).Value <> "" Then
        dd = Format(ShFm1.Range("F" & lnFm1).Value, "d")
        Cells(9 + k, 4 + dd).Value = ShFm1.Range("G" & lnFm1).Value
        '伝票枚数出力
        Cells(13 + k, 4 + dd).Value = ShFm1.Range("H" & lnFm1).Value
      Else

      End If

      o = o + 1

      '月末在庫セット
      For lnFm2 = n To lnFm2Mx
        If ShFm1.Range("C" & lnFm1).Value = ShFm2.Range("A" & lnFm2).Value Then
            '在庫数セット
            Cells(9 + k, 3).Value = ShFm2.Range("C" & lnFm2).Value
            '在庫日セット
            Cells(13 + k, 3).Value = ShFm2.Range("B" & lnFm2).Value
            getsumatsu_hinban = ShFm2.Range("A" & lnFm2).Value
            n = n + 1
            GoTo getsumatsu
        Else
            If ShFm1.Range("C" & lnFm1).Value > ShFm2.Range("A" & lnFm2).Value Then
              n = n + 1
            Else
              GoTo getsumatsu
            End If
        End If
      Next lnFm2
getsumatsu:

    Else
      dd = Format(ShFm1.Range("F" & lnFm1).Value, "d")
      '納品数出力
      Cells(9 + k, 4 + dd).Value = ShFm1.Range("G" & lnFm1).Value
      '伝票枚数出力
      Cells(13 + k, 4 + dd).Value = ShFm1.Range("H" & lnFm1).Value
    End If
Next lnFm1

'最終行の製品の入庫数・所要計画数・在庫数計算
'入庫数編集
Call Nyukosu_hensyu(mae_hinban, p, k)
'組立（入庫数）編集
Call Kumitate_hensyu(mae_hinban, r, k)
'所要計画数編集
Call Syoyoukeikakusu_hensyu(mae_hinban, q, k)
'在庫数編集
kariokiAmount = Zaikosu_hensyu(k, Date_tyousei, 0)



Application.StatusBar = False

End Function
Function mainTargetDate(Name As String, strDateRironStock As String, intTargetDay As Integer, intTargetMonth As Integer, intTargetYear As Integer)

Dim i As Integer
Dim k As Integer
Dim n As Integer
Dim o As Integer
Dim p As Integer
Dim q As Integer
Dim r As Integer

Dim amount As Long

Dim Date_tyousei As Integer
Dim Uruudoshi As Integer
Dim ShFm1 As Worksheet
Dim lnFm1 As Long
Dim lnFm1Mx As Long
Dim ShFm2 As Worksheet
Dim lnFm2 As Long
Dim lnFm2Mx As Long
Dim mae_hinban As String
Dim getsumatsu_hinban As String
Dim dd As Integer
Dim mm As Integer
Dim yyyy As Integer


'Dim dateTarget As Date
'Dim strDateTarget As String
Dim arrTyousei As Variant
Dim lastDay As Integer
Dim columnGessyo As Integer
'
'dateTarget = Range("A2").Value & "-" & Range("C2").Value & "-" & Range("E2").Value
'strDateTarget = Range("A2").Value & "-" & Range("C2").Value & "-" & Range("E2").Value

arrTyousei = getColumnGessyo(CDate(strDateRironStock))

columnGessyo = arrTyousei(0)
lastDay = arrTyousei(1)

'各日にち毎計算
Dim m As Integer
m = 1
For j = 0 To 30

    If j + intTargetDay <= lastDay Then
        Cells(8, j + 5).Value = intTargetDay + j
    Else
        Cells(8, j + 5).Value = m
        m = m + 1
    End If

Next j

Dim kariokiAmount As Long
Dim http As New XMLHTTP60
Dim url As String

Application.StatusBar = "処理中…"


'xmlデータ取込
Dim strUrl As String
'Name = "primary_dnp"
strUrl = "http://localhost:5000/Apizaikocyou/zaikocyou/api/" & strDateRironStock & "_" & Name & ".xml"
Load_xml_torikomi (strUrl)

'最終行取得
Set ShFm1 = Worksheets("OrderEdis")
lnFm1Mx = ShFm1.Range("c65536").End(xlUp).Row

Set ShFm2 = Worksheets("StockProducts")
lnFm2Mx = ShFm2.Range("a65536").End(xlUp).Row



i = 0
k = 0
n = 1
o = 0
p = 1
q = 1
r = 1
mae_hinban = ""
'納入数・伝票枚数・月末在庫編集
Dim colTyousei As Integer

For lnFm1 = 1 To lnFm1Mx
    '読み込んだレコードと格納した品番をチェック
    If ShFm1.Range("C" & lnFm1).Value <> mae_hinban Then
      '入庫数・所要計画数編集
      If mae_hinban <> "" Then
        '入庫数編集
        Call Target_nyukosu_hensyu(mae_hinban, p, k, columnGessyo, lastDay, intTargetDay, intTargetMonth, intTargetYear)
        '組立（入庫数）編集
        Call Target_kumitate_hensyu(mae_hinban, r, k, columnGessyo, lastDay, intTargetDay, intTargetMonth, intTargetYear)
        '所要計画数編集
        Call Target_syoyoukeikakusu_hensyu(mae_hinban, q, k, columnGessyo, lastDay, strDateRironStock, intTargetDay, intTargetMonth, intTargetYear)
        '在庫数編集
        'Call Zaikosu_hensyu(k, Date_tyousei)
        kariokiAmount = Zaikosu_hensyu(k, 31, 0)

      Else
      End If
      '2製品目以降、行カウンタ5行加算
      If o > 0 Then
        k = k + 5
      Else
      End If
      Cells(9 + k, 1).Value = ShFm1.Range("C" & lnFm1).Value '品番の転送
      mae_hinban = ShFm1.Range("C" & lnFm1).Value '品番の転送
      Cells(9 + k, 2).Value = ShFm1.Range("D" & lnFm1).Value '品名の転送
      Cells(9 + k, 4).Value = "納品数"
      Cells(10 + k, 4).Value = "入庫数"
      Cells(11 + k, 4).Value = "在庫数"
      Cells(12 + k, 4).Value = "所要計画"
      Cells(13 + k, 4).Value = "伝票枚数"
      '納品数セット
      If ShFm1.Range("G" & lnFm1).Value <> "" Then
        dd = Format(ShFm1.Range("F" & lnFm1).Value, "d")
        mm = Format(ShFm1.Range("F" & lnFm1).Value, "mm")
        yyyy = Format(ShFm1.Range("F" & lnFm1).Value, "yyyy")
        colTyousei = Target_column(dd, mm, yyyy, columnGessyo, lastDay, intTargetDay, intTargetMonth, intTargetYear)

        Cells(9 + k, colTyousei).Value = ShFm1.Range("G" & lnFm1).Value
        '伝票枚数出力
        Cells(13 + k, colTyousei).Value = ShFm1.Range("H" & lnFm1).Value
      Else
      End If
      o = o + 1
      '月末在庫セット
      For lnFm2 = n To lnFm2Mx
        If ShFm1.Range("C" & lnFm1).Value = ShFm2.Range("A" & lnFm2).Value Then
            '在庫数セット
            Cells(9 + k, 3).Value = ShFm2.Range("C" & lnFm2).Value
            '在庫日セット
            Cells(13 + k, 3).Value = ShFm2.Range("B" & lnFm2).Value
            getsumatsu_hinban = ShFm2.Range("A" & lnFm2).Value
            n = n + 1
            GoTo getsumatsu
        Else
            If ShFm1.Range("C" & lnFm1).Value > ShFm2.Range("A" & lnFm2).Value Then
              n = n + 1
            Else
              GoTo getsumatsu
            End If
        End If
      Next lnFm2
getsumatsu:

    Else
        dd = Format(ShFm1.Range("F" & lnFm1).Value, "d")
        mm = Format(ShFm1.Range("F" & lnFm1).Value, "mm")
        yyyy = Format(ShFm1.Range("F" & lnFm1).Value, "yyyy")
        colTyousei = Target_column(dd, mm, yyyy, columnGessyo, lastDay, intTargetDay, intTargetMonth, intTargetYear)
      '納品数出力
        Cells(9 + k, colTyousei).Value = ShFm1.Range("G" & lnFm1).Value
        '伝票枚数出力
        Cells(13 + k, colTyousei).Value = ShFm1.Range("H" & lnFm1).Value
    End If
Next lnFm1

'最終行の製品の入庫数・所要計画数・在庫数計算
'入庫数編集
Call Target_nyukosu_hensyu(mae_hinban, p, k, columnGessyo, lastDay, intTargetDay, intTargetMonth, intTargetYear)
'組立（入庫数）編集
Call Target_kumitate_hensyu(mae_hinban, r, k, columnGessyo, lastDay, intTargetDay, intTargetMonth, intTargetYear)
'所要計画数編集
Call Target_syoyoukeikakusu_hensyu(mae_hinban, q, k, columnGessyo, lastDay, strDateRironStock, intTargetDay, intTargetMonth, intTargetYear)
'在庫数編集
'Call Zaikosu_hensyu(k, Date_tyousei)
'在庫数編集
kariokiAmount = Zaikosu_hensyu(k, 31, 0)

Application.StatusBar = False

End Function
Function getColumnGessyo(dateTarget)

    Dim targetDay As Integer       '// 調べたい日付
    Dim sLast As Date      '// 末日
    Dim sLastDay As Integer  '// 末日の日のみ
    Dim arrTyousei(1) As Integer

    '// 翌月１日の前日を取得
    sLast = DateSerial(Year(dateTarget), Month(dateTarget) + 1, 0)
    '// 末日の日のみを取得
    sLastDay = Format(sLast, "d")
    '// dateTargetの日のみを取得
    targetDay = Day(dateTarget)

    columnGessyo = (sLastDay - targetDay + 1) + 1 + 4 '//月末から対象日を引き１を足し戻し、翌日の1日なので再び1を足し戻す。そしてcolumn位置調整の4を足す

    arrTyousei(0) = columnGessyo
    arrTyousei(1) = sLastDay
    getColumnGessyo = arrTyousei

End Function
Function Load_xml_torikomi(strUrl)

Dim http As XMLHTTP60
Dim doc As DOMDocument60
Dim Node As IXMLDOMNode
'Dim url As String
'Dim xmlDataNode As IXMLDOMNode
Dim xmlDataNode As IXMLDOMNodeList
'Dim yyyyTarget As Integer
'Dim mmTarget As Integer
'Dim ddTarget As Integer
Dim ws1 As Worksheet
Dim ws2 As Worksheet
Dim ws3 As Worksheet
Dim ws4 As Worksheet
Dim ws5 As Worksheet
Dim i As Integer

Set ws1 = ThisWorkbook.Worksheets("OrderEdis")
Set ws2 = ThisWorkbook.Worksheets("StockProducts")
Set ws3 = ThisWorkbook.Worksheets("AssembleProducts")
Set ws4 = ThisWorkbook.Worksheets("SyoyouKeikakus")
Set ws5 = ThisWorkbook.Worksheets("Seisans")

'xml編集ワークシート初期化
ws1.Range("A1:I65536").ClearContents
ws2.Range("A1:C65536").ClearContents
ws3.Range("A1:C65536").ClearContents
ws4.Range("A1:C65536").ClearContents
ws5.Range("A1:D65536").ClearContents

'yyyyTarget = Range("A2").Value
'mmTarget = Range("C2").Value
'ddTarget = Range("E2").Value

'初期化
Set Node = Nothing
Set xmlDataNode = Nothing
Set http = Nothing
Set doc = Nothing

'HTTPアクセスを設定して発射
Set http = New XMLHTTP60
url = strUrl
http.Open "GET", url, False
'http.setRequestHeader "Pragma", "no-cache"
'http.setRequestHeader "Cache-Control", "no-cache"
'http.setRequestHeader "If-Modified-Since", "Thu, 01 Jun 1970 00:00:00 GMT"
http.send

'HTTPアクセスに失敗があったら中止
If http.statusText <> "OK" Then
    MsgBox "サーバーへの接続に失敗しました", vbCritical
    Exit Function
End If

'XMLデータを取り込む
Set doc = New DOMDocument60
doc.LoadXML (http.responseText)

'注文呼出
Set xmlDataNode = doc.SelectNodes("//response/OrderEdis")
'XPathを使ってノード（要素）を取り込む
i = 1

If xmlDataNode Is Nothing Then

  MsgBox "xmlファイルが取得出来ません。管理者に連絡下さい。", vbCritical

Else
  For Each Node In xmlDataNode
    If Not Node.SelectSingleNode("date_order") Is Nothing Then
      '各ノードのtitle属性を取得して、シートに貼り付ける
        ws1.Range("A" & i).Value = Node.SelectSingleNode("date_order").Text
        ws1.Range("B" & i).Value = Node.SelectSingleNode("num_order").Text
        ws1.Range("C" & i).Value = Node.SelectSingleNode("product_code").Text
        ws1.Range("D" & i).Value = Node.SelectSingleNode("product_name").Text
        ws1.Range("E" & i).Value = Node.SelectSingleNode("price").Text
        ws1.Range("F" & i).Value = Node.SelectSingleNode("date_deliver").Text
        ws1.Range("G" & i).Value = Node.SelectSingleNode("amount").Text
        ws1.Range("H" & i).Value = Node.SelectSingleNode("denpyoumaisu").Text
        ws1.Range("I" & i).Value = Node.SelectSingleNode("riron_zaiko_check").Text
        i = i + 1
     Else
     End If
  Next
End If

'月末在庫呼出
Set xmlDataNode = doc.SelectNodes("//response/StockProducts")
'XPathを使ってノード（要素）を取り込む
i = 1

If xmlDataNode Is Nothing Then

  MsgBox "xmlファイルが取得出来ません。管理者に連絡下さい。", vbCritical

Else
  For Each Node In xmlDataNode
    If Not Node.SelectSingleNode("product_code") Is Nothing Then
      '各ノードのtitle属性を取得して、シートに貼り付ける
        ws2.Range("A" & i).Value = Node.SelectSingleNode("product_code").Text
        ws2.Range("B" & i).Value = Node.SelectSingleNode("date_stock").Text
        ws2.Range("C" & i).Value = Node.SelectSingleNode("amount").Text
        i = i + 1
     Else
     End If
  Next
End If

'組立品呼出
Set xmlDataNode = doc.SelectNodes("//response/AssembleProducts")
'XPathを使ってノード（要素）を取り込む
i = 1

If xmlDataNode Is Nothing Then

  MsgBox "xmlファイルが取得出来ません。管理者に連絡下さい。", vbCritical

Else
  For Each Node In xmlDataNode
    If Not Node.SelectSingleNode("product_code") Is Nothing Then
      '各ノードのtitle属性を取得して、シートに貼り付ける
        ws3.Range("A" & i).Value = Node.SelectSingleNode("product_code").Text
        ws3.Range("B" & i).Value = Node.SelectSingleNode("kensabi").Text
        ws3.Range("C" & i).Value = Node.SelectSingleNode("amount").Text
        i = i + 1
     Else
     End If
  Next
End If

'所要計画呼出
Set xmlDataNode = doc.SelectNodes("//response/SyoyouKeikakus")
'XPathを使ってノード（要素）を取り込む
i = 1

If xmlDataNode Is Nothing Then

  MsgBox "xmlファイルが取得出来ません。管理者に連絡下さい。", vbCritical

Else
  For Each Node In xmlDataNode
    If Not Node.SelectSingleNode("product_code") Is Nothing Then
      '各ノードのtitle属性を取得して、シートに貼り付ける
        ws4.Range("A" & i).Value = Node.SelectSingleNode("product_code").Text
        ws4.Range("B" & i).Value = Node.SelectSingleNode("date_deliver").Text
        ws4.Range("C" & i).Value = Node.SelectSingleNode("amount").Text
        i = i + 1
     Else
     End If
  Next
End If

'生産数呼出
Set xmlDataNode = doc.SelectNodes("//response/Seisans")
'XPathを使ってノード（要素）を取り込む
i = 1

If xmlDataNode Is Nothing Then

  MsgBox "xmlファイルが取得出来ません。管理者に連絡下さい。", vbCritical

Else
  For Each Node In xmlDataNode
    If Not Node.SelectSingleNode("product_code") Is Nothing Then
      '各ノードのtitle属性を取得して、シートに貼り付ける
        ws5.Range("A" & i).Value = Node.SelectSingleNode("product_code").Text
        ws5.Range("B" & i).Value = Node.SelectSingleNode("dateseikei").Text
        ws5.Range("C" & i).Value = Node.SelectSingleNode("amount_shot").Text
        ws5.Range("D" & i).Value = Node.SelectSingleNode("torisu").Text
        i = i + 1
     Else
     End If
  Next
End If

'後片付け
Set Node = Nothing
Set xmlDataNode = Nothing
Set http = Nothing
Set doc = Nothing

End Function
Function Load_gessyo_xml_torikomi(strUrl)

Dim http As XMLHTTP60
Dim doc As DOMDocument60
Dim Node As IXMLDOMNode
'Dim url As String
'Dim xmlDataNode As IXMLDOMNode
Dim xmlDataNode As IXMLDOMNodeList

Dim ws1 As Worksheet
Dim ws2 As Worksheet
Dim ws3 As Worksheet
Dim ws4 As Worksheet
Dim ws5 As Worksheet
Dim i As Integer

Set ws1 = ThisWorkbook.Worksheets("OrderEdis")
Set ws2 = ThisWorkbook.Worksheets("StockProducts")
Set ws3 = ThisWorkbook.Worksheets("AssembleProducts")
Set ws4 = ThisWorkbook.Worksheets("SyoyouKeikakus")
Set ws5 = ThisWorkbook.Worksheets("Seisans")

'xml編集ワークシート初期化
ws1.Range("A1:I65536").ClearContents
ws2.Range("A1:C65536").ClearContents
ws3.Range("A1:C65536").ClearContents
ws4.Range("A1:C65536").ClearContents
ws5.Range("A1:D65536").ClearContents


'初期化
Set Node = Nothing
Set xmlDataNode = Nothing
Set http = Nothing
Set doc = Nothing

'HTTPアクセスを設定して発射
Set http = New XMLHTTP60

url = strUrl
http.Open "GET", url, False
'http.setRequestHeader "Pragma", "no-cache"
'http.setRequestHeader "Cache-Control", "no-cache"
'http.setRequestHeader "If-Modified-Since", "Thu, 01 Jun 1970 00:00:00 GMT"
http.send

'HTTPアクセスに失敗があったら中止
If http.statusText <> "OK" Then
    MsgBox "サーバーへの接続に失敗しました", vbCritical
    Exit Function
End If

'XMLデータを取り込む
Set doc = New DOMDocument60
doc.LoadXML (http.responseText)

'注文呼出
Set xmlDataNode = doc.SelectNodes("//response/OrderEdis")
'XPathを使ってノード（要素）を取り込む
i = 1

If xmlDataNode Is Nothing Then

  MsgBox "xmlファイルが取得出来ません。管理者に連絡下さい。", vbCritical

Else
  For Each Node In xmlDataNode
    If Not Node.SelectSingleNode("date_order") Is Nothing Then
      '各ノードのtitle属性を取得して、シートに貼り付ける
        ws1.Range("A" & i).Value = Node.SelectSingleNode("date_order").Text
        ws1.Range("B" & i).Value = Node.SelectSingleNode("num_order").Text
        ws1.Range("C" & i).Value = Node.SelectSingleNode("product_code").Text
        ws1.Range("D" & i).Value = Node.SelectSingleNode("product_name").Text
        ws1.Range("E" & i).Value = Node.SelectSingleNode("price").Text
        ws1.Range("F" & i).Value = Node.SelectSingleNode("date_deliver").Text
        ws1.Range("G" & i).Value = Node.SelectSingleNode("amount").Text
        ws1.Range("H" & i).Value = Node.SelectSingleNode("denpyoumaisu").Text
        ws1.Range("I" & i).Value = Node.SelectSingleNode("riron_zaiko_check").Text
        i = i + 1
     Else
     End If
  Next
End If

'月末在庫呼出
Set xmlDataNode = doc.SelectNodes("//response/StockProducts")
'XPathを使ってノード（要素）を取り込む
i = 1

If xmlDataNode Is Nothing Then

  MsgBox "xmlファイルが取得出来ません。管理者に連絡下さい。", vbCritical

Else
  For Each Node In xmlDataNode
    If Not Node.SelectSingleNode("product_code") Is Nothing Then
      '各ノードのtitle属性を取得して、シートに貼り付ける
        ws2.Range("A" & i).Value = Node.SelectSingleNode("product_code").Text
        ws2.Range("B" & i).Value = Node.SelectSingleNode("date_stock").Text
        ws2.Range("C" & i).Value = Node.SelectSingleNode("amount").Text
        i = i + 1
     Else
     End If
  Next
End If

'組立品呼出
Set xmlDataNode = doc.SelectNodes("//response/AssembleProducts")
'XPathを使ってノード（要素）を取り込む
i = 1

If xmlDataNode Is Nothing Then

  MsgBox "xmlファイルが取得出来ません。管理者に連絡下さい。", vbCritical

Else
  For Each Node In xmlDataNode
    If Not Node.SelectSingleNode("product_code") Is Nothing Then
      '各ノードのtitle属性を取得して、シートに貼り付ける
        ws3.Range("A" & i).Value = Node.SelectSingleNode("product_code").Text
        ws3.Range("B" & i).Value = Node.SelectSingleNode("kensabi").Text
        ws3.Range("C" & i).Value = Node.SelectSingleNode("amount").Text
        i = i + 1
     Else
     End If
  Next
End If

'所要計画呼出
Set xmlDataNode = doc.SelectNodes("//response/SyoyouKeikakus")
'XPathを使ってノード（要素）を取り込む
i = 1

If xmlDataNode Is Nothing Then

  MsgBox "xmlファイルが取得出来ません。管理者に連絡下さい。", vbCritical

Else
  For Each Node In xmlDataNode
    If Not Node.SelectSingleNode("product_code") Is Nothing Then
      '各ノードのtitle属性を取得して、シートに貼り付ける
        ws4.Range("A" & i).Value = Node.SelectSingleNode("product_code").Text
        ws4.Range("B" & i).Value = Node.SelectSingleNode("date_deliver").Text
        ws4.Range("C" & i).Value = Node.SelectSingleNode("amount").Text
        i = i + 1
     Else
     End If
  Next
End If

'生産数呼出
Set xmlDataNode = doc.SelectNodes("//response/Seisans")
'XPathを使ってノード（要素）を取り込む
i = 1

If xmlDataNode Is Nothing Then

  MsgBox "xmlファイルが取得出来ません。管理者に連絡下さい。", vbCritical

Else
  For Each Node In xmlDataNode
    If Not Node.SelectSingleNode("product_code") Is Nothing Then
      '各ノードのtitle属性を取得して、シートに貼り付ける
        ws5.Range("A" & i).Value = Node.SelectSingleNode("product_code").Text
        ws5.Range("B" & i).Value = Node.SelectSingleNode("dateseikei").Text
        ws5.Range("C" & i).Value = Node.SelectSingleNode("amount_shot").Text
        ws5.Range("D" & i).Value = Node.SelectSingleNode("torisu").Text
        i = i + 1
     Else
     End If
  Next
End If

'後片付け
Set Node = Nothing
Set xmlDataNode = Nothing
Set http = Nothing
Set doc = Nothing

End Function
Function Nyukosu_hensyu(mae_hinban, p, k)
Dim ShFm5 As Worksheet
Dim lnFm5 As Long
Dim lnFm5Mx As Long
Dim dd As Integer
Dim nyukosu As Integer

Set ShFm5 = Worksheets("Seisans")
lnFm5Mx = ShFm5.Range("a65536").End(xlUp).Row

nyukosu = 0
dd = 0

For lnFm5 = p To lnFm5Mx
 If ShFm5.Range("A" & lnFm5).Value = mae_hinban Then
      dd = Format(ShFm5.Range("B" & lnFm5).Value, "d")
      '入庫数出力
      nyukosu = ShFm5.Range("C" & lnFm5).Value * ShFm5.Range("D" & lnFm5).Value
      Cells(10 + k, 4 + dd).Value = nyukosu
 Else
   If ShFm5.Range("A" & lnFm5).Value > mae_hinban Then
     GoTo nyukosu
   Else
     p = p + 1
   End If
 End If
Next lnFm5
nyukosu:

End Function
Function Target_nyukosu_hensyu(mae_hinban, p, k, columnGessyo As Integer, lastDay As Integer, intTargetDay As Integer, intTargetMonth As Integer, intTargetYear As Integer)
Dim ShFm5 As Worksheet
Dim lnFm5 As Long
Dim lnFm5Mx As Long
Dim dd As Integer
Dim mm As Integer
Dim yyyy As Integer
Dim nyukosu As Integer

Set ShFm5 = Worksheets("Seisans")
lnFm5Mx = ShFm5.Range("a65536").End(xlUp).Row

nyukosu = 0
dd = 0

For lnFm5 = p To lnFm5Mx
 If ShFm5.Range("A" & lnFm5).Value = mae_hinban Then
      dd = Format(ShFm5.Range("B" & lnFm5).Value, "d")
      mm = Format(ShFm5.Range("B" & lnFm5).Value, "mm")
      yyyy = Format(ShFm5.Range("B" & lnFm5).Value, "yyyy")
      Dim colTyousei As Integer
      colTyousei = Target_column(dd, mm, yyyy, columnGessyo, lastDay, intTargetDay, intTargetMonth, intTargetYear)
      '入庫数出力
      nyukosu = ShFm5.Range("C" & lnFm5).Value * ShFm5.Range("D" & lnFm5).Value
      Cells(10 + k, colTyousei).Value = nyukosu
 Else
   If ShFm5.Range("A" & lnFm5).Value > mae_hinban Then
     GoTo nyukosu
   Else
     p = p + 1
   End If
 End If
Next lnFm5
nyukosu:

End Function
Function Target_column(dd As Integer, mm As Integer, yyyy As Integer, columnGessyo As Integer, lastDay As Integer, intTargetDay As Integer, intTargetMonth As Integer, intTargetYear As Integer)

    If dd >= intTargetDay And dd <= lastDay And mm = intTargetMonth And yyyy = intTargetYear Then
        colTyousei = dd - intTargetDay + 1 + 4
    Else
        colTyousei = columnGessyo + dd - 1
    End If

    Target_column = colTyousei

End Function
Function Kumitate_hensyu(mae_hinban, r, k)
Dim ShFm3 As Worksheet
Dim lnFm3 As Long
Dim lnFm3Mx As Long
Dim dd As Integer
Dim nyukosu As Integer

Set ShFm3 = Worksheets("AssembleProducts")
lnFm3Mx = ShFm3.Range("a65536").End(xlUp).Row

nyukosu = 0
dd = 0

For lnFm3 = r To lnFm3Mx
 If ShFm3.Range("A" & lnFm3).Value = mae_hinban Then
      dd = Format(ShFm3.Range("B" & lnFm3).Value, "d")
      '入庫数出力
      Cells(10 + k, 4 + dd).Value = ShFm3.Range("C" & lnFm3).Value
 Else
   If ShFm3.Range("A" & lnFm3).Value > mae_hinban Then
     GoTo nyukosu
   Else
     r = r + 1
   End If
 End If
Next lnFm3
nyukosu:

End Function
Function Target_kumitate_hensyu(mae_hinban, r, k, columnGessyo As Integer, lastDay As Integer, intTargetDay As Integer, intTargetMonth As Integer, intTargetYear As Integer)
Dim ShFm3 As Worksheet
Dim lnFm3 As Long
Dim lnFm3Mx As Long
Dim dd As Integer
Dim mm As Integer
Dim yyyy As Integer
Dim nyukosu As Integer

Set ShFm3 = Worksheets("AssembleProducts")
lnFm3Mx = ShFm3.Range("a65536").End(xlUp).Row

nyukosu = 0
dd = 0

For lnFm3 = r To lnFm3Mx
 If ShFm3.Range("A" & lnFm3).Value = mae_hinban Then
      dd = Format(ShFm3.Range("B" & lnFm3).Value, "d")
      mm = Format(ShFm3.Range("B" & lnFm3).Value, "mm")
      yyyy = Format(ShFm3.Range("B" & lnFm3).Value, "yyyy")
      Dim colTyousei As Integer
      colTyousei = Target_column(dd, mm, yyyy, columnGessyo, lastDay, intTargetDay, intTargetMonth, intTargetYear)

      '入庫数出力
      Cells(10 + k, colTyousei).Value = ShFm3.Range("C" & lnFm3).Value
 Else
   If ShFm3.Range("A" & lnFm3).Value > mae_hinban Then
     GoTo nyukosu
   Else
     r = r + 1
   End If
 End If
Next lnFm3
nyukosu:

End Function
Function Syoyoukeikakusu_hensyu(mae_hinban, q, k)
Dim ShFm4 As Worksheet
Dim lnFm4 As Long
Dim lnFm4Mx As Long
Dim dd As Integer

Set ShFm4 = Worksheets("SyoyouKeikakus")
lnFm4Mx = ShFm4.Range("a65536").End(xlUp).Row

dd = 0

For lnFm4 = q To lnFm4Mx
 If ShFm4.Range("A" & lnFm4).Value = mae_hinban Then
      dd = Format(ShFm4.Range("B" & lnFm4).Value, "d")
      '所要計画数出力
      Cells(12 + k, 4 + dd).Value = ShFm4.Range("C" & lnFm4).Value
 Else
   If ShFm4.Range("A" & lnFm4).Value > mae_hinban Then
     GoTo syoyousu
   Else
     q = q + 1
   End If
 End If
Next lnFm4
syoyousu:


End Function
Function Target_syoyoukeikakusu_hensyu(mae_hinban, q, k, columnGessyo As Integer, lastDay As Integer, strDateTarget As String, intTargetDay As Integer, intTargetMonth As Integer, intTargetYear As Integer)
Dim ShFm4 As Worksheet
Dim lnFm4 As Long
Dim lnFm4Mx As Long
Dim dd As Integer
Dim mm As Integer
Dim yyyy As Integer

Set ShFm4 = Worksheets("SyoyouKeikakus")
lnFm4Mx = ShFm4.Range("a65536").End(xlUp).Row

dd = 0

For lnFm4 = q To lnFm4Mx
 If ShFm4.Range("A" & lnFm4).Value = mae_hinban Then

      dd = Format(ShFm4.Range("B" & lnFm4).Value, "d")
      mm = Format(ShFm4.Range("B" & lnFm4).Value, "mm")
      yyyy = Format(ShFm4.Range("B" & lnFm4).Value, "yyyy")
      Dim colTyousei As Integer
      colTyousei = Target_column(dd, mm, yyyy, columnGessyo, lastDay, intTargetDay, intTargetMonth, intTargetYear)
      '所要計画数出力

      If colTyousei > columnGessyo Then
        Cells(12 + k, colTyousei).Value = ShFm4.Range("C" & lnFm4).Value
      Else
        If yyyy = Format(strDateTarget, "yyyy") And mm = Format(strDateTarget, "mm") Then
            Cells(12 + k, colTyousei).Value = ShFm4.Range("C" & lnFm4).Value
        End If
      End If

 Else
   If ShFm4.Range("A" & lnFm4).Value > mae_hinban Then
     GoTo syoyousu
   Else
     q = q + 1
   End If
 End If
Next lnFm4
syoyousu:


End Function
Function Zaikosu_hensyu(k, Date_tyousei, intTargetDay)
Dim i As Integer
Dim amount As Long
amount = 0
    For i = 1 To Date_tyousei
      '在庫自動計算
      If i = 1 Then '月初の在庫だけは末在庫から引く

        Cells(11 + k, 4 + i).Value = Cells(9 + k, 3).Value

      Else

        Cells(11 + k, 4 + i).Value = Cells(11 + k, 4 + i - 1).Value + Cells(10 + k, 4 + i - 1).Value - Cells(9 + k, 4 + i - 1).Value - Cells(12 + k, 4 + i - 1).Value

        If i = intTargetDay Then
            amount = Cells(11 + k, 4 + i).Value
        End If

      End If

      '合計行算出
      If i = Date_tyousei Then
        Cells(11 + k, 36).Value = Cells(11 + k, 4 + i).Value + Cells(10 + k, 4 + i).Value - Cells(9 + k, 4 + i).Value - Cells(12 + k, 4 + i).Value
      Else
      End If
    Next i

    Zaikosu_hensyu = amount

End Function

Function Target_zaikosu_hensyu(k, Date_tyousei, columnGessyo, lastDay)
Dim i As Integer
Dim amount As Long

    For i = 1 To Date_tyousei
      '在庫自動計算
      If i = 1 Then '月初の在庫だけは末在庫から引く

        Cells(11 + k, 4 + i).Value = Cells(9 + k, 3).Value

      Else

        Cells(11 + k, 4 + i).Value = Cells(11 + k, 4 + i - 1).Value + Cells(10 + k, 4 + i - 1).Value - Cells(9 + k, 4 + i - 1).Value - Cells(12 + k, 4 + i - 1).Value

        If i = 16 Then
            amount = Cells(11 + k, 4 + i).Value
        End If

      End If
      '合計行算出
      If i = Date_tyousei Then
        Cells(11 + k, 36).Value = Cells(11 + k, 4 + i).Value + Cells(10 + k, 4 + i).Value - Cells(9 + k, 4 + i).Value - Cells(12 + k, 4 + i).Value
      Else
      End If
    Next i

    Zaikosu_hensyu = amount

End Function
