PHP_ARG_ENABLE([portable_xh_helper],
  [whether to enable portable_xh_helper support],
  [AS_HELP_STRING([--enable-portable_xh_helper],
    [Enable portable_xh_helper support])],
  [no])

if test "$PHP_PORTABLE_XH_HELPER" != "no"; then
  AC_DEFINE(HAVE_PORTABLE_XH_HELPER, 1, [ Have portable_xh_helper support ])

  PHP_NEW_EXTENSION(portable_xh_helper, portable_xh_helper.c, $ext_shared)
fi
