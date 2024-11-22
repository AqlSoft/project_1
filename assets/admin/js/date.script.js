window.onload = function () {
    let newDate = document.getElementById('date-1').value
    console.log(newDate)
    var today = new Date();
    var d = today.getFullYear() + "/" + today.getDate() + "/" + (today.getMonth()+1);
    document.getElementById('gregResult').value = d;
    console.log(d);
  
  
    var cal1 = new Calendar(),
        cal2 = new Calendar(true, 0, false, true),
        date1 = document.getElementById('date-1'),
        date2 = document.getElementById('date-2'),
        cal1Mode = cal1.isHijriMode(),
        cal2Mode = cal2.isHijriMode();
  
    document.getElementById('cal-1').appendChild(cal1.getElement());
    document.getElementById('cal-2').appendChild(cal2.getElement());
    cal1.hide();
    cal2.hide();
    setDateFields();
  
    cal1.callback = function() {
      if (cal1Mode !== cal1.isHijriMode()) {
        cal2.disableCallback(true);
        cal2.changeDateMode();
        cal2.disableCallback(false);
        cal1Mode = cal1.isHijriMode();
        cal2Mode = cal2.isHijriMode();
      }
      else
        cal2.setTime(cal1.getTime());
      setDateFields();
    };
  
    cal2.callback = function() {
      if (cal2Mode !== cal2.isHijriMode()) {
        cal1.disableCallback(true);
        cal1.changeDateMode();
        cal1.disableCallback(false);
        cal1Mode = cal1.isHijriMode();
        cal2Mode = cal2.isHijriMode();
      }
      else
        cal1.setTime(cal2.getTime());
      setDateFields();
    };
  
    function setDateFields() {
      date1.value = cal1.getDate().getDateString();
      date2.value = cal2.getDate().getDateString();
    }
  
    function showCal1() {
      if (cal1.isHidden()) cal1.show();
      else cal1.hide();
    }
  
    function showCal2() {
      if (cal2.isHidden()) cal2.show();
      else cal2.hide();
    }
  }