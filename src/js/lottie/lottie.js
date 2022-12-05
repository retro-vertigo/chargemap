document.addEventListener('DOMContentLoaded', function () {
  console.log('load');

  LottieInteractivity.create({
    mode: 'cursor',
    player: '#mission',
    actions: [
        {
          type: "hover",
          forceFlag: false
        }
    ]
  });

  LottieInteractivity.create({
    mode: 'cursor',
    player: '#solution',
    actions: [
        {
          type: "hover",
          forceFlag: false
        },
      ],
  });

});