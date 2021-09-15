<HTML lang="js">
<BODY>

<canvas id='canvas' width='800px' height='800px' style='border:80px solid #424141'>
</canvas>

<script>

    function draw_circle_brezenhelm(radius, x_begin, y_begin) {
        var x = 0;
        var y = radius;
        var F = 3 - 2 * radius;
        var error = 0;
        ctx.fillStyle = '#000000'
        while (y >= 0) {
            ctx.fillRect(x_begin + x, y_begin + y, 1, 1);
            ctx.fillRect(x_begin + x, y_begin - y, 1, 1);
            ctx.fillRect(x_begin - x, y_begin + y, 1, 1);
            ctx.fillRect(x_begin - x, y_begin - y, 1, 1);
            error = 2 * (F + y) - 1;
            if (F < 0 && error <= 0) {
                x++;
                F += 2 * x + 1;
                continue;
            }
            error = 2 * (F - x) - 1;
            if (F > 0 && error > 0) {
                y--;
                F += 1 - 2 * y;
                continue;
            }
            ++x;
            F += 2 * (x - y);
            --y;
        }
    }

    function white_strelka(a, b) {
        ctx.fillStyle = '#ffffff'
        ctx.fillRect(a, b, 1, 1)
    }

    function sign(begin, end) {
        return (end - begin) / Math.abs(end - begin);
    }

    function need_switch(x_begin, y_begin, x_end, y_end) {
        const angle = Math.asin(Math.abs(y_begin - y_end) / Math.sqrt((x_begin - x_end) *
            (x_begin - x_end) + (y_begin - y_end) * (y_begin - y_end))) * 180 / Math.PI;
        return (angle > 45 && angle <= 90);

    }

    function algorithm_brezenhelma(a, b, a_end, b_end, a_begin, b_begin, flag) {
        ctx.fillStyle = '#000000'
        let eps = 0;
        while (a !== a_end) {
            eps = eps + 2 * (b_end - b_begin);
            if (Math.abs(eps) >= Math.abs(a_end - a_begin)) {
                console.log(a, b)
                b = b + sign(b_begin, b_end);
                eps = eps - sign(b_begin, b_end) * sign(a_begin, a_end) * 2 * (a_end - a_begin);
                if (flag) {
                    ctx.fillRect(a, b, 1, 1);
                } else ctx.fillRect(b, a, 1, 1);
            } else {
                if (flag) {
                    ctx.fillRect(a, b, 1, 1);
                } else ctx.fillRect(b, a, 1, 1);
            }
            if (flag) {
                setTimeout(white_strelka, 700, a, b);
            } else
                setTimeout(white_strelka, 700, b, a);
            a = a + sign(a_begin, a_end)
        }
        return 0
    }

    function strelka(x_begin, y_begin, x_end, y_end) {
        const x = x_begin;
        const y = y_begin;
        const flag = need_switch(x_begin, y_begin, x_end, y_end);
        if (flag) {
            algorithm_brezenhelma(y, x, y_end, x_end, y_begin, x_begin, false)
        } else {
            algorithm_brezenhelma(x, y, x_end, y_end, x_begin, y_begin, true)
        }
        return 0
    }

    function clock(x_begin, y_begin) {
        const time_now = Date.now();
        const angle = Math.floor(time_now % 60000 / 1000) * 6 + 90;
        const y_end = Math.floor(Math.abs(400 * Math.sin(angle * Math.PI / 180) - y_begin));
        const x_end = Math.floor(Math.abs(400 * Math.cos(angle * Math.PI / 180) - x_begin));
        strelka(x_begin, y_begin, x_end, y_end);
    }

</script>

<script>
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    const x_begin = 400, y_begin = 400;
    draw_circle_brezenhelm(400, 400, 400)
    //    ctx.arc(x_begin, y_begin, 400, 0, 2 * Math.PI, true)
    //   ctx.stroke();
    setInterval(clock, 1000, x_begin, y_begin);

</script>
<!line(x0, y0, x1, y1, '#000000');>
</BODY>
</HTML>