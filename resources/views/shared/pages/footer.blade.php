<footer class="app-footer">
    <div class="float-end d-none d-sm-inline">
        <b id="footerTimer"></b>
    </div> 
    <strong>Sub-System Request System</strong>&nbsp;
    <small>v1.0</small>
</footer>

<script type="text/javascript">
    setInterval( () => {
        var now = new Date();
        $("#footerTimer").text(now.toLocaleString('en-US', { timeZone: 'Asia/Manila' }));
    }, 1000);
</script>