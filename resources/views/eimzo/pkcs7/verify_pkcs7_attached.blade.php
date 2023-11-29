@extends('adminlte::page')

@section('title', 'Example App')

@section('content_header')
@stop
@section('content')
    <form name=testform>
        <label id="message"></label>
        Выберите ключ <br />
        <select name="key" onchange="cbChanged(this)"></select><br />
        Текст для подписи <br />
        <textarea class="form-control" name="data"></textarea><br />
        <button onclick="sign()" type="button">Подписать</button><br />
        ID ключа <label id="keyId"></label><br />
        Подписанный документ PKCS#7<br />
        <textarea class="form-control" name="pkcs7"></textarea><br />
        <br />
        <label>Результат проверки</label><br />
        <textarea class="form-control" name="verifyResult"></textarea><br />
    </form>
@stop
@section('js')
    <script src="/vendor/eimzo/assets/js/eimzo/e-imzo.js"></script>
    <script src="/vendor/eimzo/assets/js/eimzo/e-imzo-client.js"></script>
    <script src="/vendor/eimzo/assets/js/eimzo/micro-ajax.js"></script>
    <script>

        var EIMZO_MAJOR = 3;
        var EIMZO_MINOR = 37;


        var errorCAPIWS = 'Ошибка соединения с E-IMZO. Возможно у вас не установлен модуль E-IMZO или Браузер E-IMZO.';
        var errorBrowserWS = 'Браузер не поддерживает технологию WebSocket. Установите последнюю версию браузера.';
        var errorUpdateApp = 'ВНИМАНИЕ !!! Установите новую версию приложения E-IMZO или Браузера E-IMZO.<br /><a href="https://e-imzo.uz/main/downloads/" role="button">Скачать ПО E-IMZO</a>';
        var errorWrongPassword = 'Пароль неверный.';


        var AppLoad = function () {
            EIMZOClient.API_KEYS = [
                'localhost', '96D0C1491615C82B9A54D9989779DF825B690748224C2B04F500F370D51827CE2644D8D4A82C18184D73AB8530BB8ED537269603F61DB0D03D2104ABF789970B',
                '127.0.0.1', 'A7BCFA5D490B351BE0754130DF03A068F855DB4333D43921125B9CF2670EF6A40370C646B90401955E1F7BC9CDBF59CE0B2C5467D820BE189C845D0B79CFC96F',
                'null',      'E0A205EC4E7B78BBB56AFF83A733A1BB9FD39D562E67978CC5E7D73B0951DB1954595A20672A63332535E13CC6EC1E1FC8857BB09E0855D7E76E411B6FA16E9D',
                'dls.yt.uz', 'EDC1D4AB5B02066FB3FEB9382DE6A7F8CBD095E46474B07568BC44C8DAE27B3893E75B79280EA82A38AD42D10EA0D600E6CE7E89D1629221E4363E2D78650516',
                'reestr.agro.uz', 'C55F15788BE5DD04DCC42FEEEAB06858F2E05F0CEA950A7AEBE724741B1F164D25E515CC1FC5A30596D784F6C6E205B5D224A682818D3C332EA09C4B57777792'
            ];
            uiLoading();
            EIMZOClient.checkVersion(function(major, minor){
                var newVersion = EIMZO_MAJOR * 100 + EIMZO_MINOR;
                var installedVersion = parseInt(major) * 100 + parseInt(minor);
                if(installedVersion < newVersion) {
                    uiUpdateApp();
                } else {
                    EIMZOClient.installApiKeys(function(){
                        uiLoadKeys();
                    },function(e, r){
                        if(r){
                            uiShowMessage(r);
                        } else {
                            wsError(e);
                        }
                    });
                }
            }, function(e, r){
                if(r){
                    uiShowMessage(r);
                } else {
                    uiNotLoaded(e);
                }
            });
        }


        var uiShowMessage = function(message){
            alert(message);
        }

        var uiLoading = function(){
            var l = document.getElementById('message');
            l.innerHTML = 'Загрузка ...';
            l.style.color = 'red';
        }

        var uiNotLoaded = function(e){
            var l = document.getElementById('message');
            l.innerHTML = '';
            if (e) {
                wsError(e);
            } else {
                uiShowMessage(errorBrowserWS);
            }
        }

        var uiUpdateApp = function(){
            var l = document.getElementById('message');
            l.innerHTML = errorUpdateApp;
        }

        var uiLoadKeys = function(){
            uiClearCombo();
            EIMZOClient.listAllUserKeys(function(o, i){
                var itemId = "itm-" + o.serialNumber + "-" + i;
                return itemId;
            },function(itemId, v){
                return uiCreateItem(itemId, v);
            },function(items, firstId){
                uiFillCombo(items);
                uiLoaded();
                uiComboSelect(firstId);
            },function(e, r){
                uiShowMessage(errorCAPIWS);
            });
        }

        var uiComboSelect = function(itm){
            if(itm){
                var id = document.getElementById(itm);
                id.setAttribute('selected','true');
            }
        }

        var cbChanged = function(c){
            document.getElementById('keyId').innerHTML = '';
        }

        var uiClearCombo = function(){
            var combo = document.testform.key;
            combo.length = 0;
        }

        var uiFillCombo = function(items){
            var combo = document.testform.key;
            for (var itm in items) {
                combo.append(items[itm]);
            }
        }

        var uiLoaded = function(){
            var l = document.getElementById('message');
            l.innerHTML = '';
        }

        var uiCreateItem = function (itmkey, vo) {
            var now = new Date();
            vo.expired = dates.compare(now, vo.validTo) > 0;
            var itm = document.createElement("option");
            itm.value = itmkey;
            itm.text = vo.CN;
            if (!vo.expired) {

            } else {
                itm.style.color = 'gray';
                itm.text = itm.text + ' (срок истек)';
            }
            itm.setAttribute('vo',JSON.stringify(vo));
            itm.setAttribute('id',itmkey);
            return itm;
        }

        var wsError = function (e) {
            if (e) {
                uiShowMessage(errorCAPIWS + " : " + e);
            } else {
                uiShowMessage(errorBrowserWS);
            }
        };
        verify = function (pkcs7wtst, detached, data, callback){
            var data64;
            if(detached){
                data64 = Base64.encode(data);
            }
            microAjax('/verify.php', function (data, s) {
                console.log(data,s)
                var result;
                try {
                    var data = JSON.parse(data);
                    if (data.status != 1) {
                        uiShowMessage(data.status + " - " + s.message);
                        return;
                    }
                    result = data.pkcs7Info;
                } catch (e) {
                    uiShowMessage(s.status + " - " + s.statusText + "<br />" + e);
                }
                callback(result);
            }, 'pkcs7wtst=' + encodeURIComponent(pkcs7wtst) + (detached ? '&data64=' + encodeURIComponent(data64) : ""));
        }
        attachTimestamp = function (pkcs7, callback){
            microAjax('/timestamp.php', function (data, s) {
                console.log(data)

                if(s.status != 200){
                    uiShowMessage(s.status + " - " + s.statusText);
                    return;
                }
                var pkcs7wtst;
                try {
                    var data = JSON.parse(data);
                    console.log(data)
                    if (data.status != 1) {
                        uiShowMessage(data.status + " - " + s.message);

                        return;
                    }
                    pkcs7wtst = data.pkcs7b64;
                } catch (e) {
                    uiShowMessage(s.status + " - " + s.statusText + "<br />" + e);

                }
                callback(pkcs7wtst);
            },'pkcs7=' +encodeURIComponent(pkcs7));
        }
        sign = function () {
            var itm = document.testform.key.value;
            if (itm) {
                var id = document.getElementById(itm);
                var vo = JSON.parse(id.getAttribute('vo'));
                var data = document.testform.data.value;
                var keyId = document.getElementById('keyId').innerHTML;
                if(keyId){
                    EIMZOClient.createPkcs7(keyId, data, null, function(pkcs7){
                        document.testform.pkcs7.value = pkcs7;
                    }, function(e, r){
                        if(r){
                            if (r.indexOf("BadPaddingException") != -1) {
                                uiShowMessage(errorWrongPassword);
                            } else {
                                uiShowMessage(r);
                            }
                        } else {
                            document.getElementById('keyId').innerHTML = '';
                            uiShowMessage(errorBrowserWS);
                        }
                        if(e) wsError(e);
                    });
                } else {
                    EIMZOClient.loadKey(vo, function(id){
                        document.getElementById('keyId').innerHTML = id;
                        EIMZOClient.createPkcs7(id, data, null, function(pkcs7){
                            document.testform.pkcs7.value = pkcs7;
                            attachTimestamp(pkcs7, function(pkcs7wtst) {
                                verify(pkcs7wtst, false, data, function (result) {
                                    document.testform.verifyResult.value = JSON.stringify(result,'',' ');
                                    console.log(result);
                                });
                            });
                        }, function(e, r){
                            if(r){
                                if (r.indexOf("BadPaddingException") != -1) {
                                    uiShowMessage(errorWrongPassword);
                                } else {
                                    uiShowMessage(r);
                                }
                            } else {
                                document.getElementById('keyId').innerHTML = '';
                                uiShowMessage(errorBrowserWS);
                            }
                            if(e) wsError(e);
                        });
                    }, function(e, r){
                        if(r){
                            if (r.indexOf("BadPaddingException") != -1) {
                                uiShowMessage(errorWrongPassword);
                            } else {
                                uiShowMessage(r);
                            }
                        } else {
                            uiShowMessage(errorBrowserWS);
                        }
                        if(e) wsError(e);
                    });
                }
            }
        };
        window.onload = AppLoad;

    </script>
@stop