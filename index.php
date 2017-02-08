<html>
    <head>
        <link rel="stylesheet" type="css/text" href="test.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="action_page.php" method="POST" name="form2">
            <input type="hidden" name="type" id="type" value="busca">
            <table border="1">
                <tbody>
                    <tr>
                        <td>CPF:</td>
                        <td><input maxlength="14" type="text" name="cpf" id="cpf" value="" onKeyPress="MascaraCPF(form2.cpf);"></td>
                        <td><input type="submit" value="Buscar"></td>
                    </tr>
                </tbody>
            </table>
        </form>
        <form action="action_page.php" method="POST" name="form1">
            <input type="hidden" name="type" id="type" value="cadastro">
            <table border="2">
                <tbody>
                    <tr>
                        <td>CPF:</td>
                        <td><input maxlength="14" type="text" name="cpf" id="cpf" value="" onKeyPress="MascaraCPF(form1.cpf);"></td>
                    </tr>
                    <tr>
                        <td>E-mail:</td>
                        <td><input type="email" name="email" id="email" value=""></td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td><input type="text" name="name" id="name" value=""></td>
                    </tr>
                    <tr>
                        <td>Fone:
                            <input type="button" name="more" id="more" value="+">
                            <input type="button" name="less" id="less" value=" - ">
                        </td>
                        <td><div id="telefone">
                                <input maxlength="15" type="text" name="fone" ite="1" id="fone_1" value="" onKeyPress="MascaraTelefone(form1.fone);" >
                            </div></td>
                    </tr>
                    <tr>
                        <td>Estado Civil:</td>
                        <td><select name="marital_status" id="marital_status" class="selectpicker" prompt="Selecione uma opção">
                                <option value="0">Selecione uma opção</option>
                                <option value="1">Solteiro</option>
                                <option value="2">Casado</option>
                                <option value="3">Divorciado</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center"><input type="submit" value="Cadastrar"></td>
                    </tr>
                </tbody>
            </table>
        </form>         
    </body>
</html>
<script>
    jQuery("input[name='more']").click(function () {
        var ultimo = jQuery("input[name='fone']").last().attr('ite');
        var iteracao = parseInt(ultimo) + 1;
        var novo = '<br /><input maxlength="15" type="text" name="fone_' + (iteracao) + '" ite="' + (iteracao) + '" id="fone_' + (iteracao) + '" value="" onKeyPress="MascaraTelefone(form1.fone_' + (iteracao) + ');" >'
        jQuery("div[id='telefone']").append(novo);
    });
    jQuery("input[name='less']").click(function () {
        jQuery("input[name*='fone_']").last().remove();
    });


    //adiciona mascara ao telefone
    function MascaraTelefone(tel) {
        if (mascaraInteiro(tel) == false) {
            event.returnValue = false;
        }
        return formataCampo(tel, '(00) 0000-0000', event);
    }

    //adiciona mascara ao CPF
    function MascaraCPF(cpf) {
        if (mascaraInteiro(cpf) == false) {
            event.returnValue = false;
        }
        return formataCampo(cpf, '000.000.000-00', event);
    }

    //valida numero inteiro com mascara
    function mascaraInteiro() {
        if (event.keyCode < 48 || event.keyCode > 57) {
            event.returnValue = false;
            return false;
        }
        return true;
    }

    //formata de forma generica os campos
    function formataCampo(campo, Mascara, evento) {
        var boleanoMascara;

        var Digitato = evento.keyCode;
        exp = /\-|\.|\/|\(|\)| /g
        campoSoNumeros = campo.value.toString().replace(exp, "");

        var posicaoCampo = 0;
        var NovoValorCampo = "";
        var TamanhoMascara = campoSoNumeros.length;
        ;

        if (Digitato != 8) { // backspace 
            for (i = 0; i <= TamanhoMascara; i++) {
                boleanoMascara = ((Mascara.charAt(i) == "-") || (Mascara.charAt(i) == ".")
                        || (Mascara.charAt(i) == "/"))
                boleanoMascara = boleanoMascara || ((Mascara.charAt(i) == "(")
                        || (Mascara.charAt(i) == ")") || (Mascara.charAt(i) == " "))
                if (boleanoMascara) {
                    NovoValorCampo += Mascara.charAt(i);
                    TamanhoMascara++;
                } else {
                    NovoValorCampo += campoSoNumeros.charAt(posicaoCampo);
                    posicaoCampo++;
                }
            }
            campo.value = NovoValorCampo;
            return true;
        } else {
            return true;
        }
    }
</script>