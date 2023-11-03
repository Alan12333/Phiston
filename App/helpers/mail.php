<?php

import("HTMLMAIL");

class Mail{
    public static function SendInfoMail($correo, $empresa, $soldto)
    {
        $renderhtml = HTMLMAIL::AddBlock(function(){
    
            $html = HTMLMAIL::Column(function(){
                
            },"width:100%;");
        
            $html .= HTMLMAIL::Column(function(){
        
                return HTMLMAIL::AddRow(function(){
        
                    return HTMLMAIL::AddImage("https://dev.busman.com.mx//requisicion2/App/public/img/Logo-Blanco.png", "150");
        
                }, "width:100%;");
        
            },"width:100%;");
        
            return $html;
        
        }, 'background:rgb(0,92,192);');
        
        $renderhtml.= HTMLMAIL::AddBlock(function() use ($empresa, $soldto){
            
            $html = HTMLMAIL::Column(function() use ($empresa, $soldto){
                return HTMLMAIL::AddRow(function() use ($empresa, $soldto){
        
                    $mail =  HTMLMAIL::AddTitle("Soldto vencido", 'text-align:center; font-size:14px;');
                    $mail.= HTMLMAIL::AddParagraph("El soldto $soldto perteneciente a la empresa $empresa esta vencido, te pedimos que te pongas en contacto con el responsable de renovar el soporte.", 'text-align:center; font-size:14px;');
        
                    return $mail;
        
                },'width:90%; margin-left:20px; color:black;');
                
            },"width:100%; ");
            return $html;
        });
        
        
        $renderhtml.= HTMLMAIL::AddBlock(function(){
            
            $html = HTMLMAIL::Column(function(){
                // Primera columna para el logo o información adicional
                return HTMLMAIL::AddImage("https://dev.busman.com.mx/requisicion2/App/public/img/Logo.png", "100");
            },"width:30%;");
        
            $html .= HTMLMAIL::Column(function(){
                // Segunda columna para los enlaces o información de contacto
                $textos = ["Contacto:","Teléfono: 4626071753", "Correo electrónico: <a href='mailto:contacto@busman.com.mx'> contacto@busman.com.mx </a>"];
                $html = HTMLMAIL::ForIn($textos, HTMLMAIL::AddText("{item}","font-size:12px"));
                return $html;
            },"width:40%;");
        
            $html .= HTMLMAIL::Column(function(){
                // Tercera columna para los enlaces de redes sociales
                $html = HTMLMAIL::AddText("Redes Sociales", 'font-size: 12px;');
                $html .= HTMLMAIL::LinkImage("#","https://busman.com.mx//App/public/icon/fb.png","20");
                $html .= HTMLMAIL::LinkImage("#","https://busman.com.mx//App/public/icon/tw.png","20");
                $html .= HTMLMAIL::LinkImage("#","https://busman.com.mx//App/public/icon/link.png","20");
                return $html;
        
            },"width:30%;");
        
            return $html;
        
        }, 'background:#f2f2f2; padding:10px; text-align: center;');
        
        $renderhtml .= HTMLMAIL::AddBlock(function(){
            // Segundo bloque del footer, puede contener más información o enlaces adicionales
            $arreglo =["© 2023 Todos los derechos reservados.", "Este es un correo automático, por favor no responder."];
            $html = HTMLMAIL::ForIn($arreglo, HTMLMAIL::AddText("{item}", 'font-size: 10px; text-align:center;'));
            return $html;
        }, 'background:#e6e6e6; padding:5px; text-align: center; width:80%;');
        
        
        $htmlContent = HTMLMAIL::Render($renderhtml);
        mail($correo,"Soporte vencido", $htmlContent, HTMLMAIL::getheaders());
    }

    public static function sendMailToClient($mail)
    {
        $renderhtml = HTMLMAIL::AddBlock(function(){
            $html  = HTMLMAIL::Column(function(){
                return HTMLMAIL::AddImage("https://dev.busman.com.mx/I4.0/App/public/img/blue.png", "150");
            }, "width:20%;");
            $html .= HTMLMAIL::Column(function(){
            }, "width:10%");
            $html .= HTMLMAIL::Column(function(){
                $ht = HTMLMAIL::Column(function(){
                    return HTMLMAIL::AddImage("https://dev.busman.com.mx/I4.0/App/public/img/si.gif", "120");
                }, "width:33%;");
                $ht .= HTMLMAIL::Column(function(){
                    return HTMLMAIL::AddImage("https://dev.busman.com.mx/I4.0/App/public/img/solid.gif", "200");
                }, "width:33%;");
                $ht .= HTMLMAIL::Column(function(){
                    return HTMLMAIL::AddImage("https://dev.busman.com.mx/I4.0/App/public/img/nx.png", "50");
                }, "width:33%;");
                return $ht;
            }, "width:70%");
            
            return $html;
        }, "width:100%;");

        $renderhtml .= HTMLMAIL::AddBlock(function(){
            return HTMLMAIL::Column(function(){
                return HTMLMAIL::AddImage("https://dev.busman.com.mx/I4.0/App/public/img/img.png", "100%");
            },"width:100%");
        }, "width:100%");

        $renderhtml .= HTMLMAIL::AddBlock(function(){
            $ht =  HTMLMAIL::Column(function(){},"width:5%");
            $ht .= HTMLMAIL::Column(function(){
                return HTMLMAIL::AddParagraph("<br><br>
                    Para el equipo de BUSMAN es un gusto saludarlo, le recordamos que al adquirir
                    su licencia de SIEMENS NX / Solid Edge con BUSMAN I4.0 usted cuenta con
                    soporte técnico y atención personalizada por parte del equipo técnico experto
                    en el software. <br><br>
                    ¡Gracias por su confianza!<br>
                ");
            },"width:90%");
            $ht .= HTMLMAIL::Column(function(){},"width:5%");
            return $ht;
        }, "width:100%; background:rgb(0,92,192); color:white;");

        $renderhtml.= HTMLMAIL::AddBlock(function(){
            
            $html = HTMLMAIL::Column(function(){
                // Primera columna para el logo o información adicional
                return HTMLMAIL::AddImage("https://dev.busman.com.mx/requisicion2/App/public/img/Logo.png", "100");
            },"width:30%;");
        
            $html .= HTMLMAIL::Column(function(){
                // Segunda columna para los enlaces o información de contacto
                $textos = ["Contacto:","Teléfono: 4626071753", "Correo electrónico: <a href='mailto:contacto@busman.com.mx'> contacto@busman.com.mx </a>"];
                $html = HTMLMAIL::ForIn($textos, HTMLMAIL::AddText("{item}","font-size:12px"));
                return $html;
            },"width:40%;");
        
            $html .= HTMLMAIL::Column(function(){
                // Tercera columna para los enlaces de redes sociales
                $html = HTMLMAIL::AddText("Redes Sociales", 'font-size: 12px;');
                $html .= HTMLMAIL::LinkImage("https://www.facebook.com/busmangroup/","https://busman.com.mx//App/public/icon/fb.png","20");
                $html .= HTMLMAIL::LinkImage("https://twitter.com/busmangroup","https://busman.com.mx//App/public/icon/tw.png","20");
                $html .= HTMLMAIL::LinkImage("https://www.linkedin.com/company/busman-group/","https://busman.com.mx//App/public/icon/link.png","20");
                return $html;
        
            },"width:30%;");
        
            return $html;
        
        }, 'width:100%; background:#f2f2f2; padding:10px; text-align: center;');
        
        $renderhtml .= HTMLMAIL::AddBlock(function(){
            // Segundo bloque del footer, puede contener más información o enlaces adicionales
            $arreglo =["© 2023 Todos los derechos reservados.", "Este es un correo automático, por favor no responder."];
            $html = HTMLMAIL::ForIn($arreglo, HTMLMAIL::AddText("{item}", 'font-size: 10px; text-align:center;'));
            return $html;
        }, 'background:#e6e6e6; padding:5px; text-align: center; width:100%;');

        $htmlContent = HTMLMAIL::Render($renderhtml);

        mail($mail,"Soporte vencido", $htmlContent, HTMLMAIL::getheaders());
    }

    public static function TestMail()
    {
        $render = HTMLMAIL::AddBlock(function(){
            $ht = HTMLMAIL::Column(function(){}, "width:35%; padding:10px;");
            $ht.= HTMLMAIL::Column(function(){
                return HTMLMAIL::AddImage("https://upload.wikimedia.org/wikipedia/commons/thumb/d/d1/Sam%27s_Club_Logo_2020.svg/2560px-Sam%27s_Club_Logo_2020.svg.png", "100%");
            }, "width:30%; padding:10px;");
            $ht.= HTMLMAIL::Column(function(){}, "width:35%; padding:10px;");
            return $ht;
        }, "width:100%; background:rgb(231,231,231);");

        $render .= HTMLMAIL::AddBlock(function(){
            $ht = HTMLMAIL::AddText("<br>Hola <b style='color:rgb(0,91,192);'> Raul Cabrera </b><br>", " text-align:center; font-size:20px;");
            
            $ht.= HTMLMAIL::AddBlock(function(){
                $h = HTMLMAIL::AddTitle("<br>!APROVECHA NUESTRAS PROMOCIONES¡<br><br>", "text-align:center; color:rgb(0,92,192); font-size:20px;");
                $h.= HTMLMAIL::AddImage("https://revistasociosams.com/wp-content/uploads/2023/04/membresias-abril-destacada-768x397.jpg", "100%", "display:block; margin:auto;");
                $h .= HTMLMAIL::AddParagraph("<br>Disfruta de todos los beneficios de tu membresía Sam's Club también en línea y aprovecha todas nuestras promociones.<br>", "width:90%; margin:auto; text-align:center; font-size:15px;");
                $h .= HTMLMAIL::AddButton("Comprar ahora", "busman.com.mx", "background:green; border:radius:12px; text-align:center;");
                return $h;
            }, "background:white; margin:auto;");

            return $ht;
        },"width:100%; background:rgb(231,231,231);");

        $htmlContent = HTMLMAIL::Render($render);
        mail("ana.arredondo@busman.com.mx","Ofertas del Club", $htmlContent, HTMLMAIL::getheaders("Sams Club Mexico <noreply@sams.com.mx>"));
    }
}

?>