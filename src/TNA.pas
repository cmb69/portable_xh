unit TNA;

// Code based on http://www.swissdelphicenter.ch/torry/showcode.php?id=221

interface

uses
  Windows, Messages, SysUtils, Classes, Controls, Forms, ExtCtrls,
  ShellApi, Menus;

const
  k_WM_TASKMSG = WM_APP + 2403;

type
  TForm1 = class(TForm)
    TPopupMenu1: TPopupMenu;
    Close1: TMenuItem;
    About1: TMenuItem;
    Display1: TMenuItem;
    procedure FormCreate(Sender: TObject);
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
    procedure Close1Click(Sender: TObject);
    procedure About1Click(Sender: TObject);
    procedure Display1Click(Sender: TObject);
  private
    tTNA: TNotifyIconData;
    hPHPCGI: THandle;
    procedure WMTaskMsg(var Msg: TMessage); message k_WM_TASKMSG;
    procedure ShowIcon;
    function ExecuteBGProcess(CmdLine: String): THandle;
  public
  end;

var
  Form1: TForm1;


implementation

uses About;


{$R *.DFM}


procedure TForm1.FormCreate(Sender: TObject);
begin
  Application.ShowMainForm := False;
  Self.ShowIcon;
  ExecuteBGProcess('nginx.exe');
  hPHPCGI := ExecuteBGProcess('php\php-cgi.exe -b 127.0.0.1:9000 -c php\php.ini');
  ShellExecute(Handle, 'open', 'http://localhost:8080', nil, nil, SW_SHOWNORMAL)
end;


procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
begin
	TerminateProcess(hPHPCGI, 0);
	ExecuteBGProcess('nginx.exe -s stop');
  Shell_NotifyIcon(NIM_DELETE, @tTNA);
end;


procedure TForm1.WMTaskMsg(var Msg: TMessage);
var
  rCursor: TPoint;
begin
  if (DWord(Msg.wParam) = tTNA.uID) and (Msg.lParam = WM_RBUTTONDOWN) then begin
    GetCursorPos(rCursor);
    SetForegroundWindow(Self.Handle);
    TPopupMenu1.Popup(rCursor.x, rCursor.y);
  end;
end;


procedure TForm1.ShowIcon;
begin
  tTNA.cbSize := SizeOf(tTNA);
  tTNA.Wnd    := Self.Handle;
  tTNA.uID    := 24031969;
  tTNA.uCallbackMessage := k_WM_TASKMSG;
  tTNA.hIcon  := LoadIcon(hInstance, 'MAINICON');
  StrCopy(tTNA.szTip, 'Portable_XH running');
  tTNA.uFlags := NIF_MESSAGE or NIF_ICON or NIF_TIP;
  Shell_NotifyIcon(NIM_ADD, @tTNA);
end;


procedure TForm1.Close1Click(Sender: TObject);
begin
	Self.Close
end;

procedure TForm1.About1Click(Sender: TObject);
begin
	AboutDialog.Show
end;

function TForm1.ExecuteBGProcess(CmdLine: String): THandle;
var
	si: TStartupInfo;
  pi: TProcessInformation;
begin
  FillChar(si, SizeOf(TStartupInfo), 0);
  si.cb := SizeOf(TStartupInfo);
  si.dwFlags := STARTF_USESHOWWINDOW;
  si.wShowWindow := SW_HIDE;
  CreateProcess(nil, PChar(CmdLine), nil, nil, False, NORMAL_PRIORITY_CLASS,
  		nil, PChar(GetCurrentDir), si, pi);
  Result := pi.hProcess;
end;

procedure TForm1.Display1Click(Sender: TObject);
begin
  ShellExecute(Handle, 'open', 'http://localhost:8080', nil, nil, SW_SHOWNORMAL)
end;

end.

