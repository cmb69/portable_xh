program Portable_XH;

uses
  Forms,
  TNA in 'TNA.pas' {Form1},
  About in 'About.pas' {AboutDialog};

{$R *.RES}

begin
  Application.Initialize;
  Application.CreateForm(TForm1, Form1);
  Application.CreateForm(TAboutDialog, AboutDialog);
  Application.Run;
end.
