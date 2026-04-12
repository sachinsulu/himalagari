<?php
$resfaq = '';

$faqRec = Faq::find_all();

if ($faqRec) {
    $resfaq .= '
    <section class="faq-wrapper components">
        <h4 class="text-center mb-2">
            Frequently Asked Questions
        </h4>

        <h2 class="text-center green-title mb-5">
            Everything you need to <span class="orange-text">know.</span>
        </h2>

        <div class="accordion container faq_content" id="accordionExample">';

    foreach ($faqRec as $key => $faqRow) {
        $show = ($key == 0) ? 'show' : '';
        $collapsed = ($key == 0) ? '' : 'collapsed';
        $expanded = ($key == 0) ? 'true' : 'false';

        $resfaq .= '
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button ' . $collapsed . '" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq' . $faqRow->id . '" aria-expanded="' . $expanded . '" aria-controls="faq' . $faqRow->id . '">
                        ' . $faqRow->title . '
                    </button>
                </h2>

                <div id="faq' . $faqRow->id . '" class="accordion-collapse collapse ' . $show . '" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        ' . $faqRow->content . '
                    </div>
                </div>
            </div>';
    }

    $resfaq .= '
        </div>

    </section>';
}

$jVars['module:faq-destination'] = $resfaq;
?>
