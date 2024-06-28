<?php
/**
 * @var array $periods
 * @var array $themes
 * @var array $filter
 */
?>
<section id="filters">
    <div class="row">
        <form data-sf-form-id="182"
              data-is-rtl="0"
              data-maintain-state=""
              data-display-result-method="custom"
              data-use-history-api="1"
              data-template-loaded="0"
              data-lang-code="nl"
              data-ajax="1"
              data-ajax-data-type="html"
              data-ajax-links-selector=".pagination a"
              data-ajax-target="#all-video-results"
              data-ajax-pagination-type="infinite_scroll"
              data-show-scroll-loader="1"
              data-infinite-scroll-trigger="-100"
              data-infinite-scroll-result-class=".video"
              data-update-ajax-url="1"
              data-only-results-ajax="1"
              data-scroll-to-pos="0"
              data-init-paged="1"
              data-auto-update="1"
              data-auto-count="1"
              data-auto-count-refresh-mode="1"
              action="#filters"
              method="get"
              id="search-filter-form-182"
              class="searchandfilter"
              autocomplete="off"
              data-instance-count="1"
              data-np-autofill-form-type="other"
              data-np-checked="1"
              data-np-watching="1">
            <ul id="filter-videos">
                <li class="sf-field-search" data-sf-field-name="search" data-sf-field-type="search" data-sf-field-input-type="">
                    <h4>Zoeken op naam</h4>
                    <label>
                        <?php
                        $search = $filter['search'] ?? '';
                        ?>
                        <input id="_sf_search" placeholder="Zoeken …" name="_sf_s" class="sf-input-text" type="text" value="<?php echo $search; ?>" title="" data-np-intersection-state="visible"></label>		</li><li class="sf-field-taxonomy-periode" data-sf-field-name="_sft_periode" data-sf-field-type="taxonomy" data-sf-field-input-type="select"><h4>Periode</h4>		<label>
                        <select id="_sft_periode" name="_sft_periode" class="sf-input-select" title="" data-np-intersection-state="visible">
                            <option class="sf-level-0 sf-item-0 sf-option-active" selected="selected" data-sf-count="0" data-sf-depth="0" value="">Alle periodes</option>
                            <?php
                            foreach ($periods as $period) {
                                if (isset($filter['period']) && $period->slug === $filter['period']) {
                                    $selected = 'selected';
                                } else {
                                    $selected = '';
                                }
                                ?>
                                <option class="sf-level-0 sf-item-30" data-sf-count="<?php echo $period->count; ?>" data-sf-depth="0" value="<?php echo $period->slug; ?>" <?php echo $selected; ?>><?php echo $period->name; ?>&nbsp;&nbsp;(<?php echo $period->count; ?>)</option>
                            <?php } ?>
                        </select>
                    </label>
                </li>
                <li class="sf-field-taxonomy-thema" data-sf-field-name="_sft_thema" data-sf-field-type="taxonomy" data-sf-field-input-type="select"><h4>Thema</h4>		<label>
                        <select id="_sft_thema" name="_sft_thema" class="sf-input-select" title="" data-np-intersection-state="visible">
                            <option class="sf-level-0 sf-item-0 sf-option-active" selected="selected" data-sf-count="0" data-sf-depth="0" value="">Alle thema's</option>
                            <?php
                            foreach($themes as $theme) {
                                if (isset($filter['theme']) && $theme->slug === $filter['theme']) {
                                    $selected = 'selected';
                                } else {
                                    $selected = '';
                                }
                                ?>
                                <option class="sf-level-0 sf-item-9" data-sf-count="<?php echo $theme->count; ?>" data-sf-depth="0" value="<?php echo $theme->slug; ?>" <?php echo $selected; ?>><?php echo $theme->name; ?>&nbsp;&nbsp;(<?php echo $theme->count; ?>)</option>
                            <?php } ?>
                        </select>
                    </label>
                </li>
                <li id="_sft_reset" class="sf-field-reset" data-sf-field-name="reset" data-sf-field-type="reset" data-sf-field-input-type="link"><a href="#" class="search-filter-reset" data-search-form-id="182" data-sf-submit-form="always">Wis alle filters</a></li>
            </ul>
        </form>
    </div>
</section>
