<div class="footer">
    <div class="float-right">

    </div>
    <div>
        <strong>Copyright</strong> {{ (\DB::table('rebranding_setting')->value('site_title') ? ucfirst(\DB::table('rebranding_setting')->value('site_title')) : 'ERP') }} &copy; {{ Date('Y') }}
    </div>
</div>
