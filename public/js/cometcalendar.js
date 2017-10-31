/* JS for the Comet Calendar Plugin */

/**
 * UTD Comet Calendar JS API options.
 *
 * These need to be set as global vars because the API currently reads them that way.
 */
var disableLink = cometcalendar_options['disable_link'] || '';
var time = cometcalendar_options['time'] || '';
var title = cometcalendar_options['title'] || '';
var z_location = cometcalendar_options['z_location'] || '';
var contact_name = cometcalendar_options['contact_name'] || '';
var contact_email = cometcalendar_options['contact_email'] || '';
var contact_phone = cometcalendar_options['contact_phone'] || '';
var description = cometcalendar_options['description'] || '';
var website = cometcalendar_options['website'] || '';
var tags = cometcalendar_options['tags'] || '';
var img_loc = cometcalendar_options['img_loc'] || '';
var formatTime = cometcalendar_options['format_time'] || '';
var publisher = cometcalendar_options['publisher'] || '';
var socialHtml = cometcalendar_options['social_html'] || '';
var accommodation = cometcalendar_options['accommodation'] || '';

/**
 * CometCalendar Module.
 * 
 * @param  {Object} $          jQuery alias
 * @param  {undefined}         making sure undefined is really undefined
 * @return {Object}            public methods and properties
 */
var cometcalendar = (function($, options, undefined) {

  /** @var {jQuery} the calendar container */
  var $calendar;

  /**
   * Orders events.
   * 
   * @param  {string} order Either 'asc' or 'desc'
   */
  var orderEvents = function(order) {
    if (order === 'asc') {
      var $events = $calendar.children('div');
      $calendar.append($events.get().reverse());
    }
  }

  /**
   * Limits the shown events.
   * 
   * @param  {int} limit         How many events to show
   * @param  {string} limit_showing Limit by showing 'earliest' or 'latest' events
   */
  var limitEventsTo = function(limit, limit_showing) {
    var $events = $calendar.children('div');
    var num_excess_events = $events.length - limit;
    if (num_excess_events > 0) {
      if (limit_showing === 'earliest') {
        $events.slice(0,num_excess_events).remove();
      } else {
        $events.slice(limit).remove();
      }
    }
  }

  /**
   * Limits the shown events to a particular timeframe.
   * 
   * @param  {string|int} year Show events from the given year, the 'current' year, or just 'future' events
   */
  var limitEventsToYear = function(year) {
    var $events_to_remove;

    if (year) {
      if (year == 'future') {
        var now = new Date();
        $events_to_remove = $calendar.children('div').filter(function(index) {
          var $startDate = $(this).find('.startDate');
          var event_has_startYear = $startDate.find('> span').hasClass('startYear');
          var eventStartDate = new Date($startDate.find('.startMonth').text() + ' ' + $startDate.find('.startDay').text() + ', ' + now.getFullYear());

          return event_has_startYear || eventStartDate < now;
        });
      } else if (year == (new Date()).getFullYear() || year == 'current') {
        // Events in the current year don't have a .startYear element
        $events_to_remove = $calendar.children('div').has('.startDate .startYear');
      } else {
        $events_to_remove = $calendar.children('div').not(':has(.startDate .startYear:contains('+year+'))');
      }
      
      $events_to_remove.remove();
    }
  }

  /**
   * Adds some classes and structure so that we can better target and style things.
   */
  var addStructure = function() {
    $calendar.children('div').addClass('event-panel').wrap('<div class="cometcalendar-event"></div>');
  }

  /**
   * Initialize the module.
   */
  var init = function() {
    $calendar = $('#cc' + options.feed_id);
    limitEventsToYear(options.year);
    limitEventsTo(options.limit, options.limit_showing);
    orderEvents(options.order);
    addStructure();
  };

  /** Declare the public methods and properties of the module. */
  return {
    options: options,
    init: init,
  };

})(jQuery, cometcalendar_options);

// On page load
jQuery(function() {

  cometcalendar.init();

});