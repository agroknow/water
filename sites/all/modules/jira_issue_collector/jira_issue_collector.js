(function ($) {

Drupal.behaviors.JiraIssueCollector = {
  attach: function(context, settings) {
    // Use ajax() instead of getScript() as this allows cache to be enabled.
    // This is preferable for performance reasons. The JIRA Issue Collector
    // script should not change much.
//console.log(settings.jiraIssueCollector.url);
var str = settings.jiraIssueCollector.url.replace("&amp;","&");
//console.log(str);
  jQuery.ajax({
            url: str,
        type: "get",
    cache: true,
    dataType: "script"
});
}
};

})(jQuery);
