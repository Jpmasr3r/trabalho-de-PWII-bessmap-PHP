<?php
echo $this->layout("_theme");
?>

<link rel="stylesheet" href="<?= url("themes/web/assets/css/style-faq.css") ?>">
<script src="<?= url("themes/web/assets/js/script-faqs.js") ?>" async></script>

<h1 id="title">
    <b>
        <u>
            Perguntas frequentes
        </u>
    </b>
</h1>
<div id="divFaqs">
    <i>
        <?php
        for ($i = 1; $i <= 10; $i++) {
            echo "
                <label class=\"lblFaq\">
                    <h1>
                        <i>
                            ▶
                        </i>
                        <b>
                            Pergunta {$i}
                        </b>
                    </h1>
                    <h3>
                        Resposta {$i}
                    </h3>
                </label>
            ";
        }
        ?>
    </i>
</div>