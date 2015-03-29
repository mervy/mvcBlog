<?php

/*
 * Classe auxiliar
 * Use assim:
 *  public $seo;
 *
 *   public function init() {
 *      $this->seo = new urlHelper();
 * }
 * e na página: $this->seo->urlSEO("string",'-');
 */

class auxHelper
{
    public function resumir($texto, $qnt)
    {
        $resumo = substr(strip_tags($texto), '0', $qnt);
        $last = strrpos($resumo, ' ');
        $resumo = substr($resumo, 0, $last);

        return $resumo.'...';
    }

    /**
     * http://clares.com.br/php-pegando-miniaturas-youtube-e-vimeo/
     * As variações para o VIMEO são: return $hash[0]["thumbnail_small"]; return $hash[0]["thumbnail_medium"]; ou
     * return $hash[0]["thumbnail_large"] e E as variações para o YOUTUBE são:  default.jpg, 0.jpg, 1.jpg, etc.
     *
     * @param type $video
     *
     * @return type
     */
    public function getThumbs($video)
    {
        if (is_numeric($video)) {
            $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video".'.php'));

            return $hash[0]['thumbnail_medium'];
        } else {
            return "http://img.youtube.com/vi/$video/0.jpg";
        }
    }

    public function urlSEO($string, $slug = false)
    {
        $texto = utf8_decode($string);
        $string = strtolower($texto);

        // Código ASCII das vogais
        $ascii['a'] = range(224, 230);
        $ascii['e'] = range(232, 235);
        $ascii['i'] = range(236, 239);
        $ascii['o'] = array_merge(range(242, 246), array(240, 248));
        $ascii['u'] = range(249, 252);

        // Código ASCII dos outros caracteres
        $ascii['b'] = array(223);
        $ascii['c'] = array(231);
        $ascii['d'] = array(208);
        $ascii['n'] = array(241);
        $ascii['y'] = array(253, 255);

        foreach ($ascii as $key => $item) {
            $acentos = '';
            foreach ($item as $codigo) {
                $acentos .= chr($codigo);
            }
            $troca[$key] = '/['.$acentos.']/i';
        }

        $string = preg_replace(array_values($troca), array_keys($troca), $string);

        // Slug?
        if ($slug) {
            // Troca tudo que não for letra ou número por um caractere ($slug)
            $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
            // Tira os caracteres ($slug) repetidos
            $string = preg_replace('/'.$slug.'{2,}/i', $slug, $string);
            $string = trim($string, $slug);
        }

        return $string;
    }

    public function enviaEmail($nome, $email, $site, $assunto, $mensagem, $data, $hora, $ip)
    {
        $to = 'mervyin@yahoo.com.br';
        $from = $email;
        $host = $_SERVER['HTTP_HOST'];

        /* assunto */
        $subject = "Contato do site: $host!";

        /* mensagem */
        $message = '
                        <html>
                        <head>
                        <title>Site '.$host.'</title>
                        </head>
                        <body>
                        <h4>Houve um contato realizado no site: http://'.$host.'</h4>
                        <p>Nome: <b>'.$nome.'</b></p>
                        <p>Site: <b>'.$site.'</b></p>
                        <p>Assunto: <b>'.$assunto.'</b></p>
                        <p>Mensagem: <b>'.$mensagem.'</b></p>
                        <p>Email: <b>'.$email.'</b></p>
                        <p>Data: Em <b>'.$data.'</b> às <b>'.$hora.'</b>.</p>
                        <p>IP: <b>'.$ip.'</b></p>
                        </body>
                        </html>
                        ';

        /* Para enviar email HTML, você precisa definir o header Content-type. */
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";

        /* headers adicionais */
        $headers .= "To: Merovingio <mervyin@yahoo.com.br>\r\n";
        $headers .= "From: Contato do site - $host \r\n";

        /* Enviar o email */
        mail($to, $subject, $message, $headers);

        /* Resposta para quem me contatou */
        $message2 = '
                        <html>
                        <head>
                        <title>Site '.$host.'</title>
                        </head>
                        <body>
                        <h4>Você entrou em contato conosco no site: http://'.$host.'</h4>
                        <p>Assunto: <b>'.$assunto.'</b></p>
                        <p>Mensagem: <b>'.$mensagem.'</b></p>
                        <p>Email: <b>'.$email.'</b></p>
                        <p>Data: Em <b>'.$data.'</b> às <b>'.$hora.'</b>.</p><br>
                        <p>Em breve atenderemos o seu contato. Visite-nos mais vezes e valorize
                        o nosso trabalho. <br>>Abraços!</p>
                        <p>Equipe <b>Mervy Sites</b></p>
                        </body>
                        </html>
                        ';
        /* Para enviar email HTML, você precisa definir o header Content-type. */
        $headers2 = "MIME-Version: 1.0\r\n";
        $headers2 .= "Content-type: text/html; charset=UTF-8\r\n";

        /* headers adicionais */
        $headers2 .= "To: $from \r\n";
        $headers2 .= "From: Contato feito no site - $host \r\n";
        mail($from, $subject, $message2, $headers2);
    }
}
