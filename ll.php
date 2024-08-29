<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/antd@4.0.0/dist/antd.min.css">
</head>
<body>
  <div id="app"></div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/antd@4.0.0/dist/antd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.10.4/dayjs.min.js"></script>
  <script>
    const { RangePicker } = antd.DatePicker;

    const onChange = function (date) {
      if (date) {
        console.log('Date: ', date.format('YYYY/MM/DD'));
      } else {
        console.log('Clear');
      }
    };

    const onRangeChange = function (dates, dateStrings) {
      if (dates) {
        console.log('From: ', dates[0].format('YYYY/MM/DD'), ', to: ', dates[1].format('YYYY/MM/DD'));
        console.log('From: ', dateStrings[0], ', to: ', dateStrings[1]);
      } else {
        console.log('Clear');
      }
    };

    const rangePresets = [
      { label: 'Last 7 Days', value: [dayjs().add(-7, 'd'), dayjs()] },
      { label: 'Last 14 Days', value: [dayjs().add(-14, 'd'), dayjs()] },
      { label: 'Last 30 Days', value: [dayjs().add(-30, 'd'), dayjs()] },
      { label: 'Last 90 Days', value: [dayjs().add(-90, 'd'), dayjs()] },
    ];

    $(document).ready(function() {
      const app = $('#app');

      app.append(`
        <div>
          <input type="text" id="datePicker" />
          <input type="text" id="rangePicker" />
          <input type="text" id="rangePickerWithTime" />
        </div>
      `);

      $('#datePicker').datepicker({
        onSelect: function (dateText) {
          onChange(dayjs(dateText));
        }
      });

      $('#rangePicker').datepicker({
        rangePresets: rangePresets,
        onSelect: function (dateText) {
          onRangeChange([dayjs(dateText), dayjs()], [dateText, dateText]);
        }
      });

      $('#rangePickerWithTime').datetimepicker({
        rangePresets: [
          {
            label: 'Now ~ EOD',
            value: function() {
              return [dayjs(), dayjs().endOf('day')];
            }
          },
          ...rangePresets,
        ],
        format: 'YYYY/MM/DD HH:mm:ss',
        onSelect: function (dateText) {
          onRangeChange([dayjs(dateText), dayjs()], [dateText, dateText]);
        }
      });
    });
  </script>
</body>
</html>
