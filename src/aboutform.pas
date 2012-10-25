unit AboutForm;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, FileUtil, IpHtml, Forms, Controls, Graphics,
  Dialogs, ExtCtrls, StdCtrls;

type

  { TfrmAbout }

  TfrmAbout = class(TForm)
    btnOk: TButton;
    IpHtmlPanel1: TIpHtmlPanel;
    Panel1: TPanel;
    procedure btnOkClick(Sender: TObject);
    procedure FormCreate(Sender: TObject);
    procedure IpHtmlPanel1HotClick(Sender: TObject);
  private
    { private declarations }
  public
    { public declarations }
  end;

var
  frmAbout: TfrmAbout;

implementation

uses gettext, LCLIntf;

{$R *.lfm}

{ TfrmAbout }

procedure TfrmAbout.FormCreate(Sender: TObject);
var s: TStream; l, l2: String; fn: String; html: TIpHtml;
begin
  l := ''; l2 := '';
  GetLanguageIDs(l, l2);
  if FileExists('languages/help_' + l + '.htm') then
    fn := 'languages/help_' + l + '.htm'
  else if FileExists('languages/help_' + l2 + '.htm') then
    fn := 'languages/help_' + l2 + '.htm'
  else
    fn := 'languages/help.htm';
  s := TFileStream.Create(fn, fmOpenRead);
  try
     html := TIpHtml.Create;
     html.LoadFromStream(s);
     IpHtmlPanel1.SetHtml(html);
  finally
    s.Free;
  end;
end;

procedure TfrmAbout.IpHtmlPanel1HotClick(Sender: TObject);
var node: TIpHtmlNodeA;
begin
  if IpHtmlPanel1.HotNode is TIpHtmlNodeA then begin
    node := IpHtmlPanel1.HotNode as TIpHtmlNodeA;
    OpenURL(node.HRef)
  end;
end;

procedure TfrmAbout.btnOkClick(Sender: TObject);
begin
  Close
end;

end.

