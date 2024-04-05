$('[data-flash-sale-id]').each(function(_, element) {
    const flashSaleId        = $(this).attr('data-flash-sale-id');
    const flashSaleEndAt     = $(this).attr('data-flash-sale-end-at');
    const $day               = $(`[data-flash-sale-days-id="${flashSaleId}"]`);
    const $hour              = $(`[data-flash-sale-hours-id="${flashSaleId}"]`);
    const $minute            = $(`[data-flash-sale-minutes-id="${flashSaleId}"]`);
    const $second            = $(`[data-flash-sale-seconds-id="${flashSaleId}"]`);
    const isOngoingFlashSale = $(this).attr('data-isongoing-flash-sale') == 'true';

    if (! isOngoingFlashSale) {
        return;
    }

    var timer = null;

    timer = setInterval(() => {
        __countdown__(flashSaleEndAt, ({ days, hours, minutes, seconds }) => {
            days    = days.toString().length    <= 1 ? `0${days}`    : days;
            hours   = hours.toString().length   <= 1 ? `0${hours}`   : hours;
            minutes = minutes.toString().length <= 1 ? `0${minutes}` : minutes;
            seconds = seconds.toString().length <= 1 ? `0${seconds}` : seconds;

            $day.html(days);
            $hour.html(hours);
            $minute.html(minutes);
            $second.html(seconds);

            if (+days == 0 && +hours == 0 && +minutes == 0 && +seconds == 0) {
                clearInterval(timer);
            }
        });
    }, 1000);
});

function __countdown__(endDate, callback = () => undefined) {
    let __endDate   = new Date(endDate).getTime();
    let __nowDate   = new Date().getTime();
    let __distance  = __endDate - __nowDate;

    let days    = Math.floor(__distance / (1000 * 60 * 60 * 24));
    let hours   = Math.floor((__distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    let minutes = Math.floor((__distance % (1000 * 60 * 60)) / (1000 * 60));
    let seconds = Math.floor((__distance % (1000 * 60)) / 1000);

    days    = days    < 0 ? 0 : days;
    hours   = hours   < 0 ? 0 : hours;
    minutes = minutes < 0 ? 0 : minutes;
    seconds = seconds < 0 ? 0 : seconds;

    return callback({ days, hours, minutes, seconds });
}
