Shader "AMening/SplitScreen"
{
	Properties
	{
		_MainTex1 ("Texture 1", 2D) = "white" {}
		_MainTex2 ("Texture 2", 2D) = "white" {}
		_Split("Split", Range(0,1)) = 0.5
		_AspectRatio("Aspect Ratio",Float) = 1
	}
	SubShader
	{
		Tags { "RenderType"="Opaque" }
		LOD 100

		Pass
		{
			CGPROGRAM
			#pragma vertex vert
			#pragma fragment frag
			
			#include "UnityCG.cginc"

			struct appdata
			{
				float4 vertex : POSITION;
				float2 uv : TEXCOORD0;
			};

			struct v2f
			{
				float2 uv : TEXCOORD0;
				float4 vertex : SV_POSITION;
			};

			sampler2D _MainTex1;
			sampler2D _MainTex2;
			float _Split;
			float _AspectRatio;
			float4 _MainTex_ST;
			float4 _MainTex1_TexelSize;
			float4 _MainTex2_TexelSize;

			v2f vert (appdata v)
			{
				v2f o;
				o.vertex = mul(UNITY_MATRIX_MVP, v.vertex);
				o.uv = TRANSFORM_TEX(v.uv, _MainTex);
				return o;
			}
			
			fixed4 frag (v2f i) : SV_Target
			{
				fixed4 col;
				if (i.uv.x < _Split)
				{
					float aspectratio = _MainTex1_TexelSize.z * _MainTex1_TexelSize.y;
					
					i.uv.x = 0.5f + (- _Split / 2 + i.uv.x) / aspectratio * _AspectRatio;
					col = tex2D(_MainTex1, i.uv);
				}
				else {

					float aspectratio = _MainTex2_TexelSize.z * _MainTex2_TexelSize.y;

					i.uv.x = 0.5f + ( - (1 - _Split) / 2 + i.uv.x - _Split) / aspectratio * _AspectRatio;
					col = tex2D(_MainTex2, i.uv);
				}
				// sample the texture
				return col;
			}
			ENDCG
		}
	}
}
